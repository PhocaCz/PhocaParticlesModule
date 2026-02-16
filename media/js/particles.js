document.addEventListener('DOMContentLoaded', () => {

  // Accordion
  document.querySelectorAll('.phModParticlesAccordionHeader').forEach(header => {
    header.addEventListener('click', () => {
      const currentItem = header.closest('.phModParticlesAccordionItem');
      if (!currentItem) return;

      // 1) Find the group (prefer the wrapper .phModParticlesItemFeatureAccordion)
      let groupRoot = header.closest('.phModParticlesItemFeatureAccordion');

      // 2) Fallback: if not found, use the parent element that contains multiple .phModParticlesAccordion
      if (!groupRoot) {
        const maybeItem = header.closest('.phModParticlesItem');
        if (maybeItem && maybeItem.parentElement) {
          // parentElement typically contains multiple .phModParticlesItem
          groupRoot = maybeItem.parentElement;
        } else {
          // last fallback - find the nearest common parent with multiple .phModParticlesAccordion
          let el = header.closest('.phModParticlesAccordion');
          groupRoot = el ? el.parentElement || document : document;
        }
      }

      // 3) Close all other active items only within groupRoot
      groupRoot.querySelectorAll('.phModParticlesAccordionItem.active').forEach(item => {
        if (item === currentItem) return;
        item.classList.remove('active');
        item.querySelectorAll('.phModParticlesAccordionContent, .phModParticlesAccordionImage')
          .forEach(block => block.style.maxHeight = '');
      });

      // 4) Toggle the current item
      const wasActive = currentItem.classList.contains('active');
      if (!wasActive) {
        currentItem.classList.add('active');
        currentItem.querySelectorAll('.phModParticlesAccordionContent, .phModParticlesAccordionImage')
          .forEach(block => block.style.maxHeight = block.scrollHeight + 'px');
      } else {
        currentItem.classList.remove('active');
        currentItem.querySelectorAll('.phModParticlesAccordionContent, .phModParticlesAccordionImage')
          .forEach(block => block.style.maxHeight = '');
      }
    });
  });

  // Optional: recalculate the height of open blocks on the whole page during resize
  window.addEventListener('resize', () => {
    document.querySelectorAll('.phModParticlesAccordionItem.active').forEach(open => {
      open.querySelectorAll('.phModParticlesAccordionContent, .phModParticlesAccordionImage')
        .forEach(block => block.style.maxHeight = block.scrollHeight + 'px');
    });
  });


  // ===== Slideshow =====
  //console.log('Phoca Particles: Initializing Slideshow...');
  document.querySelectorAll('.phModParticlesSlideshow').forEach(slideshow => {
    //console.log('Phoca Particles: Found slideshow instance', slideshow);
    const track = slideshow.querySelector('.phModParticlesSlideshowTrack');
    const slides = slideshow.querySelectorAll('.phModParticlesSlideshowSlide');
    const dots = slideshow.querySelectorAll('.phModParticlesSlideshowDot');
    const prevBtn = slideshow.querySelector('.phModParticlesSlideshowPrev');
    const nextBtn = slideshow.querySelector('.phModParticlesSlideshowNext');
    let current = 0;
    const total = slides.length;
    //console.log('Phoca Particles: Slides found:', total);

    function goToSlide(index) {
      if (total === 0) return;
      current = ((index % total) + total) % total;
      //console.log('Phoca Particles: Going to slide', current);
      track.style.transform = 'translateX(-' + (current * 100) + '%)';
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    if (prevBtn) {
      //console.log('Phoca Particles: Prev button found');
      prevBtn.addEventListener('click', () => {
        //console.log('Phoca Particles: Prev clicked');
        goToSlide(current - 1);
      });
    } else {
      //console.error('Phoca Particles: Prev button NOT found');
    }

    if (nextBtn) {
      //console.log('Phoca Particles: Next button found');
      nextBtn.addEventListener('click', () => {
        //console.log('Phoca Particles: Next clicked');
        goToSlide(current + 1);
      });
    } else {
      //console.error('Phoca Particles: Next button NOT found');
    }

    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        //console.log('Phoca Particles: Dot clicked', index);
        goToSlide(parseInt(dot.getAttribute('data-index'), 10));
      });
    });
  });


  // ===== Tab Content =====
  document.querySelectorAll('.phModParticlesTabContent').forEach(tabWidget => {
    const buttons = tabWidget.querySelectorAll('.phModParticlesTabButton');
    const panels = tabWidget.querySelectorAll('.phModParticlesTabPanel');

    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const idx = btn.getAttribute('data-tab-index');

        buttons.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
        panels.forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');
        const target = tabWidget.querySelector('.phModParticlesTabPanel[data-tab-index="' + idx + '"]');
        if (target) target.classList.add('active');
      });
    });
  });


  // ===== Image Gallery Lightbox =====
  document.querySelectorAll('.phModParticlesImageGallery').forEach(gallery => {
    const thumbs = Array.from(gallery.querySelectorAll('.phModParticlesImageGalleryThumb'));
    const parent = gallery.closest('.phModParticles');
    if (!parent) return;
    const lightbox = parent.querySelector('.phModParticlesImageGalleryLightbox');
    if (!lightbox) return;

    const lbImg = lightbox.querySelector('.phModParticlesImageGalleryLightboxImg');
    const prevBtn = lightbox.querySelector('.phModParticlesImageGalleryLightboxPrev');
    const nextBtn = lightbox.querySelector('.phModParticlesImageGalleryLightboxNext');
    const closeBtn = lightbox.querySelector('.phModParticlesImageGalleryLightboxClose');

    let currentIndex = 0;

    function updateLightbox(index) {
      if (index < 0) index = thumbs.length - 1;
      if (index >= thumbs.length) index = 0;
      currentIndex = index;

      const thumb = thumbs[currentIndex];
      if (thumb && lbImg) {
        lbImg.src = thumb.getAttribute('data-full-src');
      }
    }

    thumbs.forEach((thumb, idx) => {
      thumb.addEventListener('click', () => {
        currentIndex = idx;
        updateLightbox(currentIndex);
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
      });
    });

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        updateLightbox(currentIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        updateLightbox(currentIndex + 1);
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
      });
    }

    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
      }
    });

    // Keyboard navigation (only if this gallery's lightbox is active)
    document.addEventListener('keydown', (e) => {
      if (!lightbox.classList.contains('active')) return;
      if (e.key === 'ArrowLeft') updateLightbox(currentIndex - 1);
      else if (e.key === 'ArrowRight') updateLightbox(currentIndex + 1);
      else if (e.key === 'Escape') {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
      }
    });

    // Touch navigation for mobile
    let touchStartX = 0;
    let touchCurrentX = 0;
    let isDragging = false;

    lightbox.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
      lbImg.style.transition = 'none';
      isDragging = true;
    }, { passive: true });

    lightbox.addEventListener('touchmove', e => {
      if (!isDragging) return;
      touchCurrentX = e.changedTouches[0].screenX;
      const deltaX = touchCurrentX - touchStartX;
      lbImg.style.transform = `translateX(${deltaX}px)`;
    }, { passive: true });

    lightbox.addEventListener('touchend', e => {
      if (!isDragging) return;
      isDragging = false;
      const touchEndX = e.changedTouches[0].screenX;
      const deltaX = touchEndX - touchStartX;
      const threshold = 80;

      if (Math.abs(deltaX) > threshold) {
        // Prepare transitional slide out
        lbImg.style.transition = 'transform 0.3s ease-out, opacity 0.3s';
        lbImg.style.transform = deltaX > 0 ? 'translateX(100%)' : 'translateX(-100%)';
        lbImg.style.opacity = '0';

        setTimeout(() => {
          updateLightbox(deltaX > 0 ? currentIndex - 1 : currentIndex + 1);

          // Reset for slide in
          lbImg.style.transition = 'none';
          lbImg.style.transform = deltaX > 0 ? 'translateX(-100%)' : 'translateX(100%)';

          // Force reflow
          lbImg.offsetHeight;

          // Slide in
          lbImg.style.transition = 'transform 0.3s ease-out, opacity 0.3s';
          lbImg.style.transform = 'translateX(0)';
          lbImg.style.opacity = '1';
        }, 300);
      } else {
        // Snap back
        lbImg.style.transition = 'transform 0.2s ease-out';
        lbImg.style.transform = 'translateX(0)';
      }
    }, { passive: true });
  });


  // ===== Card Stack =====
  document.querySelectorAll('.phModParticlesCardStack').forEach(stack => {
    const cards = Array.from(stack.querySelectorAll('.phModParticlesCardStackCard'));
    if (cards.length === 0) return;

    // Initialize z-index and positions based on initial DOM order
    cards.forEach((card, index) => {
      card.style.setProperty('--card-index', index);
      if (index === 0) {
        card.classList.add('ph-active');
      }
    });

    stack.addEventListener('click', (e) => {
      const clickedCard = e.target.closest('.phModParticlesCardStackCard');
      // Logic: clicking the active (top) card moves it to the back
      if (!clickedCard || !clickedCard.classList.contains('ph-active')) return;

      // 1. Mark as moving
      clickedCard.classList.add('ph-move-to-back');
      clickedCard.classList.remove('ph-active');

      // 2. Wait for animation, then restructure DOM
      setTimeout(() => {
        stack.appendChild(clickedCard); // Move to end of container
        clickedCard.classList.remove('ph-move-to-back');

        // 3. Re-calculate indices for all cards based on new DOM order
        const newOrder = Array.from(stack.querySelectorAll('.phModParticlesCardStackCard'));
        newOrder.forEach((c, i) => {
          c.style.setProperty('--card-index', i);
          if (i === 0) {
            c.classList.add('ph-active');
          } else {
            c.classList.remove('ph-active');
          }
        });
      }, 300); // 300ms delay matches half the transition
    });
  });


  /* ===== Rotating ===== */
  const tracks = document.querySelectorAll('.phModParticlesImageRotate');

  if (tracks.length > 0) {

    // Function to update text content within a specific track
    function updateTextContent(track, activeFrame, trackClass) {
      const titleElement = track.querySelector('.phModParticlesImageRotateTextOverlayTitle');
      const descriptionElement = track.querySelector('.phModParticlesImageRotateTextOverlayDesc');
      const titleSuffixElement = track.querySelector('.phModParticlesImageRotateTextOverlayTitleSuffix');
      if (activeFrame && titleElement && descriptionElement && titleSuffixElement) {
        const title = activeFrame.getAttribute('data-title') || '';
        const description = activeFrame.getAttribute('data-description') || '';
        const titleSuffix = activeFrame.getAttribute('data-title-suffix') || '';
        const trackNumber = activeFrame.getAttribute('data-track') || '';
        const dataClass = activeFrame.getAttribute('data-class') || '';
        const baseClass = 'item-' + trackNumber;
        const trackClass = dataClass ? baseClass + ' ' + dataClass : baseClass;
        titleElement.innerHTML = '<div class="' + trackClass + '">' + title + '</div>';
        descriptionElement.innerHTML = '<div class="' + trackClass + '">' + description + '</div>';
        titleSuffixElement.innerHTML = '<div class="' + trackClass + '">' + titleSuffix + '</div>';
      }
    }

    // Define the function independently so we can add/remove it by name
    function handleScroll() {
      tracks.forEach(track => {
        const frames = Array.from(track.querySelectorAll('.phModParticlesImageRotateFrame'));

        // Determine looping behavior
        const isLooping = (track.getAttribute('data-loop') !== 'false');

        const totalFrames = frames.length;
        if (totalFrames === 0) return;

        // B. Mathematical logic
        const rect = track.getBoundingClientRect();
        // Distance needed to scroll to complete the animation
        const scrollableDistance = rect.height - window.innerHeight;
        const scrolledFromTop = -rect.top;

        // Normalize progress from 0 to 1
        let progress = scrolledFromTop / scrollableDistance;
        progress = Math.max(0, Math.min(1, progress));

        // Convert progress to frame index (0 to totalFrames - 1)
        let rawStep = Math.floor(progress * totalFrames);
        let currentFrameIndex;

        if (isLooping) {
          // Cyclic behavior: returns to the start after completion
          currentFrameIndex = rawStep % totalFrames;
        } else {
          // Non-cyclic behavior: stops at the last frame
          currentFrameIndex = Math.min(rawStep, totalFrames - 1);
        }


        // C. DOM (Scoped) Update
        let activeFrameElement = null;

        // 1. Image Frame Update
        frames.forEach((img, index) => {
          if (index === currentFrameIndex) {
            img.classList.add('active');
            activeFrameElement = img;
          } else {
            img.classList.remove('active');
          }
        });

        // 2. Update Dynamic Text
        updateTextContent(track, activeFrameElement);
      });
    }

    // 1. Add the standard scroll listener
    window.addEventListener('scroll', handleScroll, { passive: true });

    // Initial run
    handleScroll();
  }

});

