/* Multitechwave custom scripts extracted from Blade templates. */

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-load-more-grid]').forEach(function (grid) {
    const items = Array.from(grid.querySelectorAll('[data-load-more-item]'));
    const step = parseInt(grid.getAttribute('data-load-more-step') || '6', 10);
    const scope = grid.parentElement || document;
    const button = scope.querySelector('[data-load-more-btn], [data-load-more-button]');

    if (!items.length || !button) {
      return;
    }

    const updateButton = function () {
      const hiddenItems = items.filter(function (item) {
        return item.classList.contains('is-hidden');
      });

      if (!hiddenItems.length) {
        button.hidden = true;
        const wrap = button.closest('.tcw-load-more-wrap');
        if (wrap) {
          wrap.hidden = true;
        }
      }
    };

    button.addEventListener('click', function () {
      items
        .filter(function (item) {
          return item.classList.contains('is-hidden');
        })
        .slice(0, step)
        .forEach(function (item, index) {
          item.classList.remove('is-hidden');
          item.classList.add('is-load-more-revealed', 'is-visible');
          item.style.transitionDelay = Math.min(index * 0.06, 0.3).toFixed(2) + 's';
        });

      updateButton();
    });

    updateButton();
  });
});

document.addEventListener('DOMContentLoaded', function () {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  const revealSelectors = [
    'body > section',
    'body > .cs-hero',
    'body > .cs-bg',
    'body > .cs-cta',
    '#next_section > .container',
    'main > section',
    'main section .container > *',
    '.tcw-company-page',
    '.tcw-company-page__hero',
    '.tcw-company-page__content',
    '.tcw-company-page__content > *',
    '.tcw-footer .row > div',
    '.tcw-footer-copyright',
    '.cs-bg > .container',
    '.cs-cta .container',
    '.cs-contact',
    '.cs-contact_left',
    '.cs-contact_right',
    '.cs-contact_info li',
    '.cs-social_btns_wrap',
    '.service-card',
    '.tcw-form-field',
    '.tcw-blog-rail',
    '.tcw-blog-rail_wrap',
    '.tcw-blog-rail_slide',
    '.cs-section_heading',
    '.cs-hero_text',
    '.cs-icon_box',
    '.cs-portfolio',
    '.cs-cta_img',
    '.cs-cta_info',
    '.case-study-card',
    '.industry-card',
    '.tcw-it-service-card',
    '.tcw-it-portfolio-card',
    '.tcw-it-stat-card',
    '.tcw-it-proof-copy',
    '.tcw-it-client-proof',
    '.tcw-it-logo-item',
    '.tcw-it-logo-text',
    '.tcw-blog-card',
    '.tcw-blog-related-card',
    '.tcw-process-card',
    '.tcw-tech-card',
    '.tcw-feature-mini',
    '.tcw-detail-info-card',
    '.tcw-detail-cta',
    '.tcw-project-gallery > *',
    '.client-review-card',
    '.faq-item'
  ];

  const skipContainers = [
    '.cs-site_header',
    '.cs-preloader',
    '.tcw-floating-contact',
    '.tcw-support-chat',
    '.cs-video_popup',
    '[data-review-track]',
    '[data-blog-rail-track]',
    '.cs-slider',
    '.slick-slider'
  ].join(',');

  const elements = Array.from(document.querySelectorAll(revealSelectors.join(',')))
    .filter(function (element) {
      return !element.closest(skipContainers) && !element.classList.contains('tcw-theme-reveal');
    });

  if (!elements.length) {
    return;
  }

  const setRevealVariant = function (element) {
    if (
      element.matches('.tcw-detail-hero-media, .tcw-blog-share, .cs-cta_img') ||
      element.matches('.cs-contact_right') ||
      element.classList.contains('tcw-detail-hero-media') ||
      element.classList.contains('tcw-blog-share')
    ) {
      element.classList.add('is-reveal-right');
      return;
    }

    if (
      element.matches('.tcw-detail-hero-copy, .tcw-it-hero-copy, .cs-cta_info') ||
      element.matches('.cs-contact_left') ||
      element.classList.contains('tcw-detail-hero-copy')
    ) {
      element.classList.add('is-reveal-left');
      return;
    }

    if (
      element.matches('.cs-portfolio, .tcw-it-portfolio-card, .tcw-blog-card, .tcw-blog-related-card, .client-review-card') ||
      element.matches('.cs-icon_box, .tcw-it-logo-item, .tcw-it-logo-text, .tcw-form-field, .tcw-blog-rail_slide') ||
      element.classList.contains('tcw-process-card') ||
      element.classList.contains('tcw-tech-card') ||
      element.classList.contains('faq-item')
    ) {
      element.classList.add('is-reveal-zoom');
    }
  };

  elements.forEach(function (element) {
    element.classList.add('tcw-theme-reveal');
    setRevealVariant(element);

    const parent = element.parentElement;
    const siblings = parent ? Array.from(parent.children).filter(function (child) {
      return elements.includes(child);
    }) : [];
    const index = Math.max(0, siblings.indexOf(element));

    if (index > 0 && !element.style.transitionDelay) {
      element.style.transitionDelay = Math.min(index * 0.06, 0.36).toFixed(2) + 's';
    }
  });

  if (!('IntersectionObserver' in window)) {
    elements.forEach(function (element) {
      element.classList.add('is-visible');
    });
    return;
  }

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) {
        return;
      }

      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -8% 0px'
  });

  elements.forEach(function (element) {
    observer.observe(element);
  });

  window.setTimeout(function () {
    elements.forEach(function (element) {
      element.classList.add('is-visible');
    });
  }, 1600);
});

document.addEventListener('DOMContentLoaded', function () {
  const widget = document.querySelector('[data-support-chat]');

  if (!widget) {
    return;
  }

  const endpoint = widget.getAttribute('data-endpoint');
  const toggle = widget.querySelector('[data-support-chat-toggle]');
  const panel = widget.querySelector('[data-support-chat-panel]');
  const close = widget.querySelector('[data-support-chat-close]');
  const form = widget.querySelector('[data-support-chat-form]');
  const input = widget.querySelector('[data-support-chat-input]');
  const messages = widget.querySelector('[data-support-chat-messages]');
  const submit = widget.querySelector('[data-support-chat-submit]');
  const csrf = document.querySelector('meta[name="csrf-token"]');
  const history = [];

  const addMessage = function (role, text, status) {
    const message = document.createElement('div');
    message.className = 'tcw-support-chat__message tcw-support-chat__message--' + (status ? 'status' : role);
    message.textContent = text;
    messages.appendChild(message);
    messages.scrollTop = messages.scrollHeight;
    return message;
  };

  const setPanelOpen = function (isOpen) {
    panel.hidden = !isOpen;
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

    if (isOpen) {
      input.focus();
    }
  };

  const setLoading = function (isLoading) {
    input.disabled = isLoading;
    submit.disabled = isLoading;
  };

  const resizeInput = function () {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 120) + 'px';
  };

  toggle.addEventListener('click', function () {
    setPanelOpen(panel.hidden);
  });

  close.addEventListener('click', function () {
    setPanelOpen(false);
  });

  input.addEventListener('input', resizeInput);

  input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      form.requestSubmit();
    }
  });

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const text = input.value.trim();

    if (!text) {
      return;
    }

    addMessage('user', text);
    input.value = '';
    resizeInput();
    setLoading(true);

    const statusMessage = addMessage('assistant', 'Typing...', true);

    fetch(endpoint, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf ? csrf.getAttribute('content') : '',
      },
      body: JSON.stringify({
        message: text,
        history: history.slice(-8),
      }),
    })
      .then(function (response) {
        return response.json().catch(function () {
          if (response.status === 419) {
            return {
              reply: 'Your chat session expired. Please refresh the page and try again.',
            };
          }

          if (!response.ok) {
            return {
              reply: 'AI support had a temporary issue. Please try again in a moment.',
            };
          }

          return {
            reply: '',
          };
        });
      })
      .then(function (data) {
        const reply = data.reply || 'Sorry, I could not answer that right now. Please try again.';
        statusMessage.remove();
        addMessage('assistant', reply);
        history.push({ role: 'user', content: text });
        history.push({ role: 'assistant', content: reply });
      })
      .catch(function () {
        statusMessage.remove();
        addMessage('assistant', 'Sorry, chat support is unavailable right now. Please try again in a moment.');
      })
      .finally(function () {
        setLoading(false);
        input.focus();
      });
  });
});

// Source: resources/views/website/home.blade.php
document.addEventListener('DOMContentLoaded', function () {
    const phoneInputField = document.querySelector('#full_phone');
    const countryInput = document.querySelector('#country_name');
    const serviceRequestForm = document.querySelector('#service-request-form');
    const parallaxScene = document.querySelector('.tcw-parallax-scene');
    const parallaxLayers = parallaxScene ? parallaxScene.querySelectorAll('.tcw-parallax-layer') : [];

    if (phoneInputField && window.intlTelInput) {
      const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: 'pk',
        preferredCountries: ['pk', 'ae', 'us', 'gb', 'sa', 'qa', 'kw', 'bh', 'om'],
        separateDialCode: true,
        autoPlaceholder: 'aggressive',
        nationalMode: false,
        dropdownContainer: document.body,
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
      });

      const syncCountry = function () {
        if (!countryInput) {
          return;
        }

        const countryData = phoneInput.getSelectedCountryData();
        countryInput.value = countryData.name || '';
      };

      syncCountry();
      phoneInputField.addEventListener('countrychange', syncCountry);

      if (serviceRequestForm) {
        serviceRequestForm.addEventListener('submit', function () {
          if (phoneInput.getNumber()) {
            phoneInputField.value = phoneInput.getNumber();
          }
        });
      }
    }

    if (!parallaxScene || !parallaxLayers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    let pointerX = 0;
    let pointerY = 0;
    let currentX = 0;
    let currentY = 0;
    let scrollOffset = 0;

    const animateLayers = function () {
      currentX += (pointerX - currentX) * 0.08;
      currentY += (pointerY - currentY) * 0.08;

      parallaxLayers.forEach(function (layer) {
        const depth = Number(layer.getAttribute('data-depth') || 10);
        const moveX = (currentX * depth) / 100;
        const moveY = (currentY * depth) / 100 + scrollOffset * (depth / 18);
        layer.style.transform = 'translate3d(' + moveX.toFixed(2) + 'px, ' + moveY.toFixed(2) + 'px, 0)';
      });

      window.requestAnimationFrame(animateLayers);
    };

    const resetParallax = function () {
      pointerX = 0;
      pointerY = 0;
      parallaxLayers.forEach(function (layer) {
        layer.style.transform = 'translate3d(0, 0, 0)';
      });
    };

    parallaxScene.addEventListener('mousemove', function (event) {
      if (window.innerWidth < 992) {
        return;
      }

      const bounds = parallaxScene.getBoundingClientRect();
      pointerX = ((event.clientX - bounds.left) / bounds.width - 0.5) * 2;
      pointerY = ((event.clientY - bounds.top) / bounds.height - 0.5) * 2;
    });

    parallaxScene.addEventListener('mouseleave', resetParallax);

    window.addEventListener('scroll', function () {
      if (window.innerWidth < 992) {
        return;
      }

      scrollOffset = Math.min(window.scrollY * 0.02, 8);
    }, { passive: true });

    window.addEventListener('resize', function () {
      if (window.innerWidth < 992) {
        resetParallax();
      }
    });

    window.requestAnimationFrame(animateLayers);
  });

// Source: resources/views/website/home.blade.php
(function () {
    const slider   = document.getElementById('reviewSlider');
    const prevBtn  = document.getElementById('reviewPrev');
    const nextBtn  = document.getElementById('reviewNext');
    if (!slider) return;

    const sliderWrap = slider.closest('.tcw-review-slider-wrap');
    const slides = Array.from(slider.querySelectorAll('.tcw-review-slide'));
    let current  = 0;
    let perView  = getSlidesPerView();
    const total  = slides.length;

    /* ── dots ── */
    /* ── slides per view ── */
    function getSlidesPerView () {
      if (window.innerWidth <= 575) return 1;
      if (window.innerWidth <= 991) return 2;
      return 3;
    }

    function getSliderGap () {
      const styles = window.getComputedStyle(slider);
      return parseFloat(styles.columnGap || styles.gap) || 0;
    }

    function getWrapInnerWidth () {
      if (!sliderWrap) return 0;
      const styles = window.getComputedStyle(sliderWrap);
      const paddingX = (parseFloat(styles.paddingLeft) || 0) + (parseFloat(styles.paddingRight) || 0);
      return Math.max(0, sliderWrap.clientWidth - paddingX);
    }

    function getMaxOffset () {
      if (!sliderWrap) return 0;
      return Math.max(0, slider.scrollWidth - getWrapInnerWidth());
    }

    function getMaxIndex () {
      if (!slides[0]) return 0;
      const step = slides[0].getBoundingClientRect().width + getSliderGap();
      return step > 0 ? Math.ceil(getMaxOffset() / step) : 0;
    }

    /* ── calculate offset ── */
    function getOffset (idx) {
      if (!slides[0]) return 0;
      const slideEl    = slides[0];
      const gap        = getSliderGap();
      const slideWidth = slideEl.getBoundingClientRect().width;
      return Math.min(getMaxOffset(), Math.max(0, idx * (slideWidth + gap)));
    }

    /* ── go to slide ── */
    function goTo (idx) {
      perView  = getSlidesPerView();
      const max = getMaxIndex();
      current  = Math.min(Math.max(idx, 0), max);
      const offset = getOffset(current);
      const maxOffset = getMaxOffset();
      slider.style.transform = 'translateX(-' + offset + 'px)';
      prevBtn.disabled = offset <= 1;
      nextBtn.disabled = offset >= maxOffset - 1;
      prevBtn.hidden = offset <= 1;
      nextBtn.hidden = maxOffset <= 1 || offset >= maxOffset - 1;
      /* pause all videos except the active ones */
      slides.forEach(function (slide, i) {
        const vid = slide.querySelector('video');
        if (vid && (i < current || i >= current + perView)) vid.pause();
      });
    }

    /* ── auto-play ── */
    prevBtn.addEventListener('click', function () { goTo(current - 1); });
    nextBtn.addEventListener('click', function () { goTo(current + 1); });

    /* ── touch / swipe ── */
    let touchStartX = 0;
    slider.addEventListener('touchstart', function (e) {
      touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });
    slider.addEventListener('touchend', function (e) {
      const diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) { goTo(diff > 0 ? current + 1 : current - 1); }
    }, { passive: true });

    /* ── resize ── */
    window.addEventListener('resize', function () {
      perView = getSlidesPerView();
      goTo(Math.min(current, getMaxIndex()));
    });

    /* ── init ── */
    goTo(0);
  })();

// Source: resources/views/website/contact.blade.php
document.addEventListener('DOMContentLoaded', function () {
    const phoneInputField = document.querySelector('#contact_full_phone');
    const countryInput = document.querySelector('#contact_country_name');
    const serviceRequestForm = document.querySelector('#contact-service-request-form');

    if (!phoneInputField || !window.intlTelInput) {
      return;
    }

    const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: 'pk',
      preferredCountries: ['pk', 'ae', 'us', 'gb', 'sa', 'qa', 'kw', 'bh', 'om'],
      separateDialCode: true,
      autoPlaceholder: 'aggressive',
      nationalMode: false,
      dropdownContainer: document.body,
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
    });

    const syncCountry = function () {
      if (!countryInput) {
        return;
      }

      const countryData = phoneInput.getSelectedCountryData();
      countryInput.value = countryData.name || '';
    };

    syncCountry();
    phoneInputField.addEventListener('countrychange', syncCountry);

    if (serviceRequestForm) {
      serviceRequestForm.addEventListener('submit', function () {
        if (phoneInput.getNumber()) {
          phoneInputField.value = phoneInput.getNumber();
        }
      });
    }
  });

// Source: resources/views/website/quote-generator.blade.php
document.addEventListener('DOMContentLoaded', function () {
    const phoneInputField = document.querySelector('#quote_generator_phone');
    const countryInput = document.querySelector('#quote_generator_country');
    const quoteForm = phoneInputField ? phoneInputField.closest('form') : null;

    if (!phoneInputField || !window.intlTelInput) {
      return;
    }

    const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: 'pk',
      preferredCountries: ['pk', 'ae', 'us', 'gb', 'sa', 'qa', 'kw', 'bh', 'om'],
      separateDialCode: true,
      autoPlaceholder: 'aggressive',
      nationalMode: false,
      dropdownContainer: document.body,
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
    });

    const syncCountry = function () {
      if (!countryInput) {
        return;
      }

      const countryData = phoneInput.getSelectedCountryData();
      countryInput.value = countryData.name || '';
    };

    syncCountry();
    phoneInputField.addEventListener('countrychange', syncCountry);

    if (quoteForm) {
      quoteForm.addEventListener('submit', function () {
        if (phoneInput.getNumber()) {
          phoneInputField.value = phoneInput.getNumber();
        }

        const submitButton = quoteForm.querySelector('[data-quote-submit]');

        if (submitButton) {
          submitButton.disabled = true;
          submitButton.innerHTML = 'Submitting Quote <i class="fas fa-spinner fa-spin"></i>';
        }
      });
    }
  });

// Source: resources/views/partials/website/floating-contact.blade.php
document.addEventListener('DOMContentLoaded', function () {
    const phoneInputField = document.querySelector('#quote_full_phone');
    const countryInput = document.querySelector('#quote_country_name');

    if (!phoneInputField || !window.intlTelInput) {
      return;
    }

    const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: 'pk',
      preferredCountries: ['pk', 'ae', 'us', 'gb', 'sa', 'qa', 'kw', 'bh', 'om'],
      separateDialCode: true,
      autoPlaceholder: 'aggressive',
      nationalMode: false,
      dropdownContainer: document.body,
      utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
    });

    const syncCountry = function () {
      if (!countryInput) {
        return;
      }

      const countryData = phoneInput.getSelectedCountryData();
      countryInput.value = countryData.name || '';
    };

    syncCountry();
    phoneInputField.addEventListener('countrychange', syncCountry);

    const form = phoneInputField.closest('form');
    if (form) {
      form.addEventListener('submit', function () {
        if (phoneInput.getNumber()) {
          phoneInputField.value = phoneInput.getNumber();
        }
      });
    }
  });

// Source: resources/views/partials/website/review-slider.blade.php
(function () {
        document.querySelectorAll('[data-review-rail]').forEach(function (rail) {
          const slider = rail.querySelector('[data-review-track]');
          const prevBtn = rail.querySelector('[data-review-prev]');
          const nextBtn = rail.querySelector('[data-review-next]');
          if (!slider || !prevBtn || !nextBtn) return;

          const sliderWrap = slider.closest('.tcw-review-slider-wrap');
          const slides = Array.from(slider.querySelectorAll('.tcw-review-slide'));
          let current = 0;

          function getSlidesPerView() {
            if (window.innerWidth <= 575) return 1;
            if (window.innerWidth <= 991) return 2;
            return 3;
          }

          function getSliderGap() {
            const styles = window.getComputedStyle(slider);
            return parseFloat(styles.columnGap || styles.gap) || 0;
          }

          function getWrapInnerWidth() {
            if (!sliderWrap) return 0;
            const styles = window.getComputedStyle(sliderWrap);
            const paddingX = (parseFloat(styles.paddingLeft) || 0) + (parseFloat(styles.paddingRight) || 0);
            return Math.max(0, sliderWrap.clientWidth - paddingX);
          }

          function getMaxOffset() {
            if (!sliderWrap) return 0;
            return Math.max(0, slider.scrollWidth - getWrapInnerWidth());
          }

          function getMaxIndex() {
            if (!slides[0]) return 0;
            const step = slides[0].getBoundingClientRect().width + getSliderGap();
            return step > 0 ? Math.ceil(getMaxOffset() / step) : 0;
          }

          function getOffset(idx) {
            if (!slides[0]) return 0;
            const slideWidth = slides[0].getBoundingClientRect().width;
            return Math.min(getMaxOffset(), Math.max(0, idx * (slideWidth + getSliderGap())));
          }

          function goTo(idx) {
            const max = getMaxIndex();
            current = Math.min(Math.max(idx, 0), max);
            const offset = getOffset(current);
            const maxOffset = getMaxOffset();
            slider.style.transition = 'transform 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            slider.style.transform = 'translateX(-' + offset + 'px)';
            prevBtn.hidden = offset <= 1;
            nextBtn.hidden = maxOffset <= 1 || offset >= maxOffset - 1;
            slides.forEach(function (slide, i) {
              const video = slide.querySelector('video');
              if (video && (i < current || i >= current + getSlidesPerView())) video.pause();
            });
          }

          prevBtn.addEventListener('click', function () { goTo(current - 1); });
          nextBtn.addEventListener('click', function () { goTo(current + 1); });

          let touchStartX = 0;
          slider.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].clientX;
          }, { passive: true });
          slider.addEventListener('touchend', function (event) {
            const diff = touchStartX - event.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
          }, { passive: true });

          window.addEventListener('resize', function () {
            goTo(Math.min(current, getMaxIndex()));
          });

          goTo(0);
        });
      })();

// Source: resources/views/partials/website/blog-slider.blade.php
document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-blog-rail]').forEach(function (rail) {
          const wrap = rail.querySelector('[data-blog-rail-wrap]');
          const track = rail.querySelector('[data-blog-rail-track]');
          const prevBtn = rail.querySelector('[data-blog-rail-prev]');
          const nextBtn = rail.querySelector('[data-blog-rail-next]');

          if (!wrap || !track || !prevBtn || !nextBtn) {
            return;
          }

          const slides = Array.from(track.querySelectorAll('[data-blog-rail-slide]'));
          let current = 0;

          const getGap = function () {
            const styles = window.getComputedStyle(track);
            return parseFloat(styles.columnGap || styles.gap) || 0;
          };

          const getInnerWidth = function () {
            const styles = window.getComputedStyle(wrap);
            const paddingX = (parseFloat(styles.paddingLeft) || 0) + (parseFloat(styles.paddingRight) || 0);
            return Math.max(0, wrap.clientWidth - paddingX);
          };

          const getMaxOffset = function () {
            return Math.max(0, track.scrollWidth - getInnerWidth());
          };

          const getMaxIndex = function () {
            if (!slides[0]) return 0;
            const step = slides[0].getBoundingClientRect().width + getGap();
            return step > 0 ? Math.ceil(getMaxOffset() / step) : 0;
          };

          const getOffset = function (idx) {
            if (!slides[0]) return 0;
            const step = slides[0].getBoundingClientRect().width + getGap();
            return Math.min(getMaxOffset(), Math.max(0, idx * step));
          };

          const goTo = function (idx) {
            const max = getMaxIndex();
            current = Math.min(Math.max(idx, 0), max);
            const offset = getOffset(current);
            const maxOffset = getMaxOffset();

            track.style.transform = 'translateX(-' + offset + 'px)';
            prevBtn.hidden = offset <= 1;
            nextBtn.hidden = maxOffset <= 1 || offset >= maxOffset - 1;
          };

          prevBtn.addEventListener('click', function () {
            goTo(current - 1);
          });

          nextBtn.addEventListener('click', function () {
            goTo(current + 1);
          });

          let touchStartX = 0;
          track.addEventListener('touchstart', function (event) {
            touchStartX = event.changedTouches[0].clientX;
          }, { passive: true });

          track.addEventListener('touchend', function (event) {
            const diff = touchStartX - event.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) {
              goTo(diff > 0 ? current + 1 : current - 1);
            }
          }, { passive: true });

          window.addEventListener('resize', function () {
            goTo(Math.min(current, getMaxIndex()));
          });

          goTo(0);
        });
      });

// Source: resources/views/layouts/website.blade.php
document.addEventListener('DOMContentLoaded', function () {
        const header = document.querySelector('.tcw-site-header');

        if (!header) {
          return;
        }

        const menuToggle = header.querySelector('.tcw-menu_toggle');
        const mobilePanel = header.querySelector('.tcw-mobile_panel');
        const groupToggles = header.querySelectorAll('.tcw-mobile_group_toggle');
        const dropdowns = header.querySelectorAll('.tcw-has_dropdown');

        const closeDropdowns = function (exceptDropdown) {
          dropdowns.forEach(function (dropdown) {
            if (dropdown === exceptDropdown) {
              return;
            }

            dropdown.classList.remove('is-open');

            const toggle = dropdown.querySelector('.tcw-dropdown_toggle');
            if (toggle) {
              toggle.setAttribute('aria-expanded', 'false');
            }
          });
        };

        dropdowns.forEach(function (dropdown) {
          const toggle = dropdown.querySelector('.tcw-dropdown_toggle');

          if (!toggle) {
            return;
          }

          toggle.addEventListener('click', function (event) {
            if (window.innerWidth <= 991) {
              return;
            }

            event.preventDefault();

            const isOpen = dropdown.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            closeDropdowns(isOpen ? dropdown : null);
          });
        });

        if (menuToggle && mobilePanel) {
          const closeMobileMenu = function () {
            menuToggle.classList.remove('is-open');
            menuToggle.setAttribute('aria-expanded', 'false');
            mobilePanel.hidden = true;
          };

          menuToggle.addEventListener('click', function () {
            const isOpen = menuToggle.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            mobilePanel.hidden = !isOpen;
          });

          document.addEventListener('click', function (event) {
            if (window.innerWidth > 991) {
              return;
            }

            if (!header.contains(event.target)) {
              closeMobileMenu();
            }
          });

          window.addEventListener('resize', function () {
            if (window.innerWidth > 991) {
              closeMobileMenu();
            }
          });
        }

        document.addEventListener('click', function (event) {
          if (window.innerWidth <= 991 || header.contains(event.target)) {
            return;
          }

          closeDropdowns();
        });

        document.addEventListener('keydown', function (event) {
          if (event.key === 'Escape') {
            closeDropdowns();
          }
        });

        groupToggles.forEach(function (toggle) {
          toggle.addEventListener('click', function () {
            const group = toggle.closest('.tcw-mobile_group');
            const body = group ? group.querySelector('.tcw-mobile_group_body') : null;

            if (!group || !body) {
              return;
            }

            const isOpen = group.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            body.hidden = !isOpen;
          });
        });
      });

// Source: resources/views/layouts/website.blade.php
document.addEventListener('DOMContentLoaded', function () {
        const requestForms = document.querySelectorAll('form[data-service-request-form]');

        if (!requestForms.length) {
          return;
        }

        const labels = {
          full_name: 'Full name',
          company_name: 'Company name',
          company_website: 'Company website',
          company_email: 'Company email',
          phone_no: 'Phone number',
          service_type: 'Service',
        };

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const websitePattern = /^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/i;
        const phonePattern = /^[\d\s()+-]{7,20}$/;

        const getAnchorElement = function (field) {
          return field.closest('.phone-field-wrap') || field;
        };

        const clearFormSummary = function (form) {
          const existingSummary = form.querySelector('.js-form-error-summary');

          if (existingSummary) {
            existingSummary.remove();
          }
        };

        const showFormSummary = function (form, message) {
          clearFormSummary(form);

          const summary = document.createElement('div');
          summary.className = 'js-form-error-summary';
          summary.textContent = message;

          form.insertAdjacentElement('afterbegin', summary);
        };

        const clearFieldError = function (field) {
          field.classList.remove('is-invalid');
          field.removeAttribute('aria-invalid');

          const anchor = getAnchorElement(field);
          const next = anchor.nextElementSibling;

          if (next && next.classList.contains('js-field-error')) {
            next.remove();
          }
        };

        const showFieldError = function (field, message) {
          clearFieldError(field);
          field.classList.add('is-invalid');
          field.setAttribute('aria-invalid', 'true');

          const error = document.createElement('span');
          error.className = 'js-field-error';
          error.textContent = message;

          getAnchorElement(field).insertAdjacentElement('afterend', error);
        };

        const validateField = function (field) {
          if (field.type === 'hidden' && field.name !== 'country') {
            return true;
          }

          const value = field.value.trim();
          const fieldName = field.getAttribute('name');
          const label = labels[fieldName] || 'This field';

          clearFieldError(field);

          if (field.hasAttribute('required') && value === '') {
            showFieldError(field, label + ' is required.');
            return false;
          }

          if (fieldName === 'company_email' && value !== '' && !emailPattern.test(value)) {
            showFieldError(field, 'Please enter a valid email address.');
            return false;
          }

          if (fieldName === 'company_website' && value !== '' && !websitePattern.test(value)) {
            showFieldError(field, 'Please enter a valid website URL.');
            return false;
          }

          if (fieldName === 'phone_no' && value !== '' && !phonePattern.test(value)) {
            showFieldError(field, 'Please enter a valid phone number.');
            return false;
          }

          return true;
        };

        requestForms.forEach(function (form) {
          const fields = form.querySelectorAll('input, select, textarea');
          const phoneField = form.querySelector('input[name="phone_no"]');

          fields.forEach(function (field) {
            field.addEventListener('input', function () {
              clearFormSummary(form);
              validateField(field);
            });

            field.addEventListener('blur', function () {
              validateField(field);
            });

            field.addEventListener('change', function () {
              clearFormSummary(form);
              validateField(field);
            });
          });

          form.addEventListener('submit', function (event) {
            let isValid = true;
            let firstInvalidField = null;

            clearFormSummary(form);

            if (phoneField && window.intlTelInputGlobals) {
              const itiInstance = window.intlTelInputGlobals.getInstance(phoneField);

              if (itiInstance && typeof itiInstance.isValidNumber === 'function' && phoneField.value.trim() !== '' && !itiInstance.isValidNumber()) {
                showFieldError(phoneField, 'Please enter a valid phone number.');
                isValid = false;
                firstInvalidField = firstInvalidField || phoneField;
              }
            }

            fields.forEach(function (field) {
              if (!validateField(field)) {
                isValid = false;

                if (!firstInvalidField) {
                  firstInvalidField = field;
                }
              }
            });

            if (!isValid) {
              event.preventDefault();
              showFormSummary(form, 'Please fix the highlighted fields and try again.');

              if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
              }
            }
          });
        });
      });

// Source: resources/views/partials/website/footer.blade.php
document.querySelectorAll(".faq-question").forEach(question => {
  question.addEventListener("click", () => {
    const item = question.parentElement;

    // Close others
    document.querySelectorAll(".faq-item").forEach(i => {
      if (i !== item) i.classList.remove("active");
    });

    // Toggle current
    item.classList.toggle("active");
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const floatingContact = document.querySelector('.tcw-floating-contact');

  if (!floatingContact) {
    return;
  }

  const syncFloatingContact = function () {
    floatingContact.classList.toggle('is-visible', window.scrollY > 120);
  };

  syncFloatingContact();
  window.addEventListener('scroll', syncFloatingContact, { passive: true });
});
