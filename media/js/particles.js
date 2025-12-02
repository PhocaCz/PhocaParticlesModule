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

  /* Rotating */
  const tracks = document.querySelectorAll('.phModParticlesImageRotate');

  if (tracks.length === 0) {
    return;
  }

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
      const dataClass   = activeFrame.getAttribute('data-class') || '';
      const baseClass   = 'item-' + trackNumber;
      const trackClass  = dataClass ? baseClass + ' ' + dataClass : baseClass;
      titleElement.innerHTML = '<div class="'+ trackClass +'">' + title + '</div>';
      descriptionElement.innerHTML = '<div class="'+ trackClass +'">' + description + '</div>';
      titleSuffixElement.innerHTML = '<div class="'+ trackClass +'">' + titleSuffix + '</div>';
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

      // 2. Update Frame Counter
      /*if(frameDisplay) {
          frameDisplay.textContent = currentFrameIndex + 1;
      }*/

      // 3. Update Dynamic Text
      updateTextContent(track, activeFrameElement);
    });
  }

  // 1. Add the standard scroll listener
  window.addEventListener('scroll', handleScroll, { passive: true });

  // 2. LISTEN FOR SMOOTH SCROLL EVENTS
/// // When smooth scroll starts, we REMOVE the listener. The rotator effectively "dies" temporarily.
/// window.addEventListener('phoca-scroll-start', () => {
///       window.removeEventListener('scroll', handleScroll);
/// });

/// // When smooth scroll ends, we RE-ADD the listener and run it once to update positions.
/// window.addEventListener('phoca-scroll-end', () => {
///       window.addEventListener('scroll', handleScroll, { passive: true });
///       // Force one update to snap images to the correct state (e.g. if we scrolled past it, show last image)
///       handleScroll();
/// });

  // Initial run
  handleScroll();
});
