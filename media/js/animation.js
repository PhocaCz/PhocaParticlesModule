(function () {

    /* ------------------------------------------------------------
        Utility functions
    ------------------------------------------------------------ */
    const phUtil = {
        easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); },
        randChar() {
            const chars = "abcdefghijklmnopqrstuvwxyz";
            return chars[Math.floor(Math.random() * chars.length)];
        },
        toInt(v, fallback = 0) {
            const n = parseInt(v, 10);
            return Number.isFinite(n) ? n : fallback;
        }
    };

    /* ------------------------------------------------------------
        Shared IntersectionObserver Utility
    ------------------------------------------------------------ */
    const PhObserver = {
        observer: null,
        callbacks: new Map(),
        init() {
            if (this.observer) return;
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const cbs = this.callbacks.get(entry.target);
                    if (!cbs) return;
                    if (entry.isIntersecting) {
                        if (cbs.onEnter) cbs.onEnter(entry);
                    } else {
                        if (cbs.onLeave) cbs.onLeave(entry);
                    }
                });
            }, { threshold: 0.2 });
        },
        observe(el, onEnter, onLeave) {
            this.init();
            this.callbacks.set(el, { onEnter, onLeave });
            this.observer.observe(el);
        },
        unobserve(el) {
            if (!this.observer) return;
            this.observer.unobserve(el);
            this.callbacks.delete(el);
        }
    };

    /* ------------------------------------------------------------
        Core effect registry + single-run observer
    ------------------------------------------------------------ */
    const phEffects = {};
    function phRegister(name, fn) { phEffects[name] = fn; }
    function phRun(name, el) { if (phEffects[name]) phEffects[name](el); }

    // List of effects that are now repeatable (originally one-time)
    const cssRepeatableEffects = [
        "phAnimScaleInFade",
        "phAnimSlideUpFade",
        "phAnimSoftPop",
        "phAnimRotateInFade",
        "phAnimBlurIn",
        "phAnimFlipIn",
        "phAnimDropIn",
        "phAnimPulseIn",
        "phAnimFadeInDown"
    ];

    // List of other complex JS repeatable effects
    const jsRepeatableEffects = [
        "phAnimLetters",
        "phAnimMoveIn",
        "phAnimMoveInX",
        "phAnimMoveInY",
        "phAnimZoomImage",
        "phAnimKenBurns",
        "phAnimStepGrow",
        "phAnimStepShrink"
    ];

    /**
     * Observer for one-time animations (triggers phRun() and then disconnects).
     * Used ONLY for effects NOT listed in the repeatable arrays above.
     */
    const singleObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const fx = el.dataset.phAnimation;
            if (!fx) return;

            // Check if it's explicitly marked as non-repeating via data attribute
            if (el.dataset.once === "false") return;

            phRun(fx, el);
            singleObserver.unobserve(el); // One-time animation, disconnect observer
        });
    }, { threshold: 0.2 });

    /**
     * Initializes handling for all effects except those that have their own Observer (repeating effects).
     */
    function initObservers() {
        document.querySelectorAll("[data-ph-animation]").forEach(el => {
            const fx = el.dataset.phAnimation;

            // If the effect is in the JS repeatable OR CSS repeatable list, we ignore it here.
            // The logic in DOMContentLoaded will take care of these effects.
            if (jsRepeatableEffects.includes(fx) || cssRepeatableEffects.includes(fx)) {
                return;
            }

            // All other (truly one-time) effects are observed by singleObserver
            singleObserver.observe(el);
        });
    }

    /* ------------------------------------------------------------
        EFFECT: phAnimCounterNumber (One-Time)
    ------------------------------------------------------------ */
    phRegister("phAnimCounterNumber", (el) => {
        el.innerHTML = '0';

        const pageLanguage = document.documentElement.lang || "en-GB";
        const target = phUtil.toInt(el.dataset.target, 0);
        const duration = phUtil.toInt(el.dataset.duration, 2500);
        const start = performance.now();

        function step(now) {
            const p = Math.min(1, (now - start) / duration);
            el.textContent = Math.round(phUtil.easeOutCubic(p) * target).toLocaleString(pageLanguage);
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });

    /* ------------------------------------------------------------
        EFFECT: phAnimScrambleWord (One-Time)
    ------------------------------------------------------------ */
    phRegister("phAnimScrambleWord", (el) => {
        const word = el.dataset.word || "";
        el.innerHTML = "";
        const duration = 900;
        const revealPoint = duration * 0.85;

        word.split("").forEach((ch, i) => {
            const span = document.createElement("span");
            span.textContent = phUtil.randChar();
            el.appendChild(span);

            const start = Date.now();
            function loop() {
                const t = Date.now() - start;
                span.textContent = t < duration
                    ? (t < revealPoint ? phUtil.randChar() : ch)
                        : ch;
                if (t < duration) requestAnimationFrame(loop);
            }
            setTimeout(loop, i * 55);
        });
    });

    /* ------------------------------------------------------------
        Shared Helper for CSS Animations (Repeatable)
    ------------------------------------------------------------ */
    /**
     * Creates an IntersectionObserver for the element that toggles the '.active' class.
     * This makes the CSS animation play every time the element enters the viewport.
     */
    function phSetupCssRepeatable(el) {
        el.dataset.once = "false"; // Mark logic

        // Remove active initially to ensure clean state
        el.classList.remove("active");

        PhObserver.observe(el,
            () => el.classList.add("active"),    // onEnter
            () => el.classList.remove("active")  // onLeave
        );
    }

    // Registration of CSS effects using the new Repeatable logic
    cssRepeatableEffects.forEach(name => {
        phRegister(name, (el) => phSetupCssRepeatable(el));
    });

    /* ------------------------------------------------------------
        EFFECT: phAnimMoveIn (Repeating, JS-based reset)
    ------------------------------------------------------------ */
    function createMoveInEffect(forcedAxis = null) {
        return (el) => {
            el.dataset.once = "false";

            // Direction logic:
            // 1. If forcedAxis is (X or Y), we use that (for aliases).
            // 2. If not, we look in dataset.direction.
            // 3. Default is X.
            let axis;
            if (forcedAxis) {
                axis = forcedAxis;
            } else {
                axis = el.dataset.direction === "y" ? "Y" : "X";
            }

            const offset = phUtil.toInt(el.dataset.offset, 40);
            const initialTransform = `translate${axis}(${offset}px)`;

            el.style.opacity = "0";
            el.style.transform = initialTransform;
            el.style.transition = 'opacity 0.7s ease-out, transform 0.7s ease-out';

            PhObserver.observe(el,
                () => { // onEnter
                    el.style.opacity = "1";
                    el.style.transform = "translate(0,0)";
                },
                () => { // onLeave
                    el.style.opacity = "0";
                    el.style.transform = initialTransform;
                }
            );
        };
    }

    phRegister("phAnimMoveIn", createMoveInEffect(null));
    phRegister("phAnimMoveInX", createMoveInEffect("X"));
    phRegister("phAnimMoveInY", createMoveInEffect("Y"));


    /* ------------------------------------------------------------
        EFFECT: phAnimZoomImage (Repeating, JS-based reset)
    ------------------------------------------------------------ */
    phRegister("phAnimZoomImage", (el) => {
        el.dataset.once = "false";

        const INITIAL_SCALE = "1.2";
        const INITIAL_OPACITY = "0.5";
        const FINAL_SCALE = "1.0";
        const FINAL_OPACITY = "1.0";
        el.style.transition = 'transform 1.0s ease-out, opacity 1.0s ease-out';

        function reset() {
            el.style.transform = `scale(${INITIAL_SCALE})`;
            el.style.opacity = INITIAL_OPACITY;
        }

        function animateIn() {
            el.style.transform = `scale(${FINAL_SCALE})`;
            el.style.opacity = FINAL_OPACITY;
        }

        reset();

        PhObserver.observe(el, animateIn, reset);
    });


    /* ------------------------------------------------------------
        EFFECT: phAnimKenBurns (Repeating, CSS-based)
    ------------------------------------------------------------ */
    phRegister("phAnimKenBurns", (el) => {
        el.dataset.once = "false";

        // Determine the correct CSS class to trigger the effect
        const CLASS_NAME = (el.tagName === 'IMG'
            ? "phAnimKenBurnsImg"
            : "phAnimKenBurnsBg");

        // 1. Remove the class initially
        el.classList.remove("phAnimKenBurnsImg", "phAnimKenBurnsBg");

        // 2. Observer that adds and removes the class for reset/start animation
        PhObserver.observe(el,
            () => el.classList.add(CLASS_NAME),
            () => el.classList.remove(CLASS_NAME)
        );
    });

    /* ------------------------------------------------------------
       EFFECT: phAnimLetters (Repeating)
    ------------------------------------------------------------ */
    phRegister("phAnimLetters", (el) => {
        el.dataset.once = "false";

        const RESET_DELAY_MS = 300;
        let resetTimer = null;

        if (!el._originalHTML) el._originalHTML = el.innerHTML;

        // 1. Setup function to wrap content into permanent <span>s only once
        if (!el._spans) {
            const txt = document.createElement("textarea");
            txt.innerHTML = el._originalHTML;
            const originalHTML = txt.value.replace(/\n/g, ""); // decoded text, keeps <br>

            el.innerHTML = "";
            el._spans = [];
            let globalCharIndex = 0;

            const lines = originalHTML.split(/<br\s*\/?>/i);

            lines.forEach((line, li) => {
                const words = line.split(" ");

                words.forEach((word, wi) => {
                    if (word === "") {
                        el.appendChild(document.createTextNode(" "));
                        return;
                    }

                    const wordSpan = document.createElement("span");
                    wordSpan.style.display = "inline-block";
                    wordSpan.style.whiteSpace = "nowrap";
                    wordSpan.style.opacity = "1";
                    wordSpan.style.transform = "none";

                    for (const ch of word) {
                        const span = document.createElement("span");
                        span.textContent = ch;
                        span.style.display = "inline-block";
                        span.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';

                        // Optimization: Set delay here instead of using setTimeout loops
                        span.style.transitionDelay = `${globalCharIndex * 40}ms`;

                        // Set initial state
                        span.style.opacity = "0";
                        span.style.transform = "translateX(20px)";

                        wordSpan.appendChild(span);
                        el._spans.push(span);
                        globalCharIndex++;
                    }

                    el.appendChild(wordSpan);

                    if (wi < words.length - 1) {
                        el.appendChild(document.createTextNode(" "));
                    }
                });

                if (li < lines.length - 1) {
                    el.appendChild(document.createElement("br"));
                }
            });
        }

        // 2. Function to start the animation
        function build() {
            if (resetTimer) {
                clearTimeout(resetTimer);
                resetTimer = null;
            }

            // Trigger reflow to ensure transition works if called immediately after reset
            // void el.offsetWidth; 

            el._spans.forEach((span) => {
                span.style.opacity = 1;
                span.style.transform = "translateX(0)";
            });
        }

        // 3. Function to reset
        function reset() {
            el._spans.forEach(span => {
                // Disable transition for instant reset? 
                // Or keep it to fade out? The original logic had a complex reset with timeouts.
                // Let's keep it simple and efficient: just reset properties.
                // If we want it instant, we'd toggle a class or disable transition.
                // But since we have transition-delay set on the element, it might delay the reset too!
                // We need to override transition-delay for reset.

                span.style.transitionDelay = '0s';
                span.style.opacity = 0;
                span.style.transform = 'translateX(20px)';
            });

            // Restore delays after a small tick so they are ready for next build
            // But we can't do it immediately or it might affect the reset transition if we wanted one.
            // If we want instant reset:
            setTimeout(() => {
                el._spans.forEach((span, i) => {
                    span.style.transitionDelay = `${i * 40}ms`;
                });
            }, 50);
        }

        // 4. Shared Observer
        PhObserver.observe(el,
            build, // onEnter
            () => { // onLeave
                if (resetTimer) clearTimeout(resetTimer);
                resetTimer = setTimeout(() => {
                    reset();
                    resetTimer = null;
                }, RESET_DELAY_MS);
            }
        );
    });

    /* ------------------------------------------------------------
       EFFECT: phAnimStepGrow, phAnimStepShrink (Repeating)
    ------------------------------------------------------------ */
    function createStepShrinkEffect(minScale = 0.7, maxScale = 1, fadeRange = 0.5) {
        return (el) => {
            el.dataset.once = "false";
            el.style.transition = "transform 0.1s linear"; 
            el.style.transformOrigin = "center center";

            function updateScale() {
                const rect = el.getBoundingClientRect();
                const vh = window.innerHeight || document.documentElement.clientHeight;

                // 1. Find out where the center of the element is
                const elementCenter = rect.top + rect.height / 2;
                const viewportCenter = vh / 2;

                // 2. Logic:
                // If the element is below the center (distance > 0), we want to shrink.
                // If it is at the center or above (distance <= 0), we want max size.
                // Distance of the element's center from the viewport center (positive = below, negative = above)
                const distance = elementCenter - viewportCenter;
                
                // Determines the range (in pixels) in which the animation occurs
                // fadeRange 0.5 means over half the screen height
                const rangePx = vh * fadeRange;

                // Calculate progress from 0 to 1
                // 1 = we are at the center or above
                // 0 = we are below (out of range)
                let progress = 1 - (distance / rangePx);

                // Clip values so they don't go below 0 or above 1
                progress = Math.max(0, Math.min(1, progress));

                // Apply scale
                const scale = minScale + (maxScale - minScale) * progress;
                el.style.transform = `scale(${scale})`;
            }

            function onScrollOrResize() {
                // requestAnimationFrame for smoothness
                requestAnimationFrame(updateScale);
            }

            // Trigger when entering the viewport
            PhObserver.observe(el,
                () => { // onEnter
                    window.addEventListener("scroll", onScrollOrResize, { passive: true });
                    window.addEventListener("resize", onScrollOrResize, { passive: true });
                    updateScale(); // Immediate recalculation
                },
                () => { // onLeave
                    window.removeEventListener("scroll", onScrollOrResize);
                    window.removeEventListener("resize", onScrollOrResize);
                }
            );

            el.classList.add("phAnimStepFont");
        };
    }

    phRegister("phAnimStepGrow", createStepShrinkEffect(1, 1.25, 0.4));
    phRegister("phAnimStepShrink", createStepShrinkEffect(1, 0.75, 0.4));


    /* ------------------------------------------------------------
        Initialize system
    ------------------------------------------------------------ */
    document.addEventListener("DOMContentLoaded", () => {

        // 1. Activate JS-based repeatable effects
        jsRepeatableEffects.forEach(fxName => {
            document.querySelectorAll(`[data-ph-animation='${fxName}']`).forEach(el => {
                phRun(fxName, el);
            });
        });

        // 2. Activate CSS-based repeatable effects (Nově přidaná logika)
        cssRepeatableEffects.forEach(fxName => {
            document.querySelectorAll(`[data-ph-animation='${fxName}']`).forEach(el => {
                phRun(fxName, el); // This now calls phSetupCssRepeatable
            });
        });

        // 3. Register all other (truly one-time) effects
        initObservers();
    });

})();
