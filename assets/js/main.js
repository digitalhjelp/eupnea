/**
 * Eupnea – Hoved-JavaScript
 * Versjon: 1.0.0
 */

'use strict';

(function () {

  // ── 1. Header: Sticky & scroll-effekt ───────────────────────
  const header = document.getElementById('masthead');
  if (header) {
    let lastScroll = 0;
    const scrollThreshold = 80;

    window.addEventListener('scroll', () => {
      const current = window.scrollY;
      if (current > scrollThreshold) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
      lastScroll = current;
    }, { passive: true });
  }

  // ── 2. Mobil hamburger-meny ──────────────────────────────────
  const hamburger = document.querySelector('.hamburger');
  const nav       = document.getElementById('site-navigation');

  if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
      const isOpen = hamburger.classList.toggle('is-active');
      nav.classList.toggle('is-open', isOpen);
      hamburger.setAttribute('aria-expanded', isOpen.toString());

      // Steng med Escape
      if (isOpen) {
        document.addEventListener('keydown', closeOnEscape);
        document.addEventListener('click',   closeOnOutside);
      } else {
        cleanupListeners();
      }
    });
  }

  function closeOnEscape(e) {
    if (e.key === 'Escape') closeMobileMenu();
  }

  function closeOnOutside(e) {
    if (!header || (!header.contains(e.target))) {
      closeMobileMenu();
    }
  }

  function closeMobileMenu() {
    hamburger?.classList.remove('is-active');
    nav?.classList.remove('is-open');
    hamburger?.setAttribute('aria-expanded', 'false');
    cleanupListeners();
  }

  function cleanupListeners() {
    document.removeEventListener('keydown', closeOnEscape);
    document.removeEventListener('click',   closeOnOutside);
  }

  // ── 3. Scroll-animasjoner (Intersection Observer) ───────────
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.08, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.module:not(.hero)').forEach(el => {
      observer.observe(el);
    });
  }

  // ── 4. Testimonials slider ───────────────────────────────────
  document.querySelectorAll('.testimonials--slider').forEach(section => {
    const slides     = section.querySelectorAll('.testimonial-card--slide');
    const dots       = section.querySelectorAll('.testimonials__dot');
    const prevBtn    = section.querySelector('.testimonials__prev');
    const nextBtn    = section.querySelector('.testimonials__next');

    if (!slides.length) return;

    let current    = 0;
    let autoTimer  = null;

    function goTo(index) {
      slides[current].classList.remove('is-active');
      dots[current]?.classList.remove('is-active');

      current = (index + slides.length) % slides.length;

      slides[current].classList.add('is-active');
      dots[current]?.classList.add('is-active');
    }

    function startAuto() {
      autoTimer = setInterval(() => goTo(current + 1), 5000);
    }

    function stopAuto() {
      clearInterval(autoTimer);
    }

    prevBtn?.addEventListener('click', () => { stopAuto(); goTo(current - 1); startAuto(); });
    nextBtn?.addEventListener('click', () => { stopAuto(); goTo(current + 1); startAuto(); });

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => { stopAuto(); goTo(i); startAuto(); });
    });

    // Swipe-støtte
    let startX = 0;
    section.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    section.addEventListener('touchend', e => {
      const diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) {
        stopAuto();
        goTo(diff > 0 ? current + 1 : current - 1);
        startAuto();
      }
    });

    startAuto();

    // Stopp auto ved hover
    section.addEventListener('mouseenter', stopAuto);
    section.addEventListener('mouseleave', startAuto);
  });

  // ── 5. Partners marquee: pause ved hover ────────────────────
  document.querySelectorAll('.partners__marquee-track').forEach(track => {
    track.parentElement.addEventListener('mouseenter', () => {
      track.style.animationPlayState = 'paused';
    });
    track.parentElement.addEventListener('mouseleave', () => {
      track.style.animationPlayState = 'running';
    });
  });

  // ── 6. Smooth scroll for anker-lenker ───────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const id  = link.getAttribute('href').slice(1);
      const target = id ? document.getElementById(id) : null;
      if (target) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 0;
        const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
        window.scrollTo({ top, behavior: 'smooth' });
        closeMobileMenu();
      }
    });
  });

  // ── 7. Scroll-indikator i Hero ───────────────────────────────
  const scrollArrow = document.querySelector('.hero__scroll-indicator');
  if (scrollArrow) {
    scrollArrow.addEventListener('click', () => {
      const heroHeight = document.querySelector('.hero')?.offsetHeight ?? window.innerHeight;
      window.scrollTo({ top: heroHeight, behavior: 'smooth' });
    });
    scrollArrow.style.cursor = 'pointer';
  }

  // ── 8. Teller-animasjon for statistikk ──────────────────────
  function animateCounter(el) {
    const raw   = el.textContent.replace(/[^0-9]/g, '');
    if (!raw) return;

    const end     = parseInt(raw, 10);
    const suffix  = el.textContent.replace(/[0-9]/g, '');
    const duration = 1800;
    const start   = performance.now();

    function step(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased    = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(eased * end) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    document.querySelectorAll('.about__stat-number').forEach(el => {
      counterObserver.observe(el);
    });
  }

  // ── 9. Aktiv navigasjons-lenke basert på scroll ──────────────
  const sections    = document.querySelectorAll('section[id]');
  const navLinks    = document.querySelectorAll('.nav-menu a[href*="#"]');

  if (sections.length && navLinks.length) {
    const sectionObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          navLinks.forEach(link => {
            link.classList.toggle(
              'current-in-view',
              link.getAttribute('href').endsWith('#' + id)
            );
          });
        }
      });
    }, { rootMargin: '-40% 0px -40% 0px' });

    sections.forEach(s => sectionObserver.observe(s));
  }

  // ── 10. Ansatt-popup ────────────────────────────────────────
  const body = document.body;

  function openPopup(popupId) {
    const popup = document.getElementById(popupId);
    if (!popup) return;

    popup.removeAttribute('hidden');
    body.style.overflow = 'hidden';
    popup.querySelector('.ansatt-popup__content')?.scrollTo(0, 0);

    // Sett fokus på lukk-knappen
    const closeBtn = popup.querySelector('.ansatt-popup__close');
    setTimeout(() => closeBtn?.focus(), 50);

    // Fange fokus inni popupen
    popup.addEventListener('keydown', trapFocus);
    popup._trapFocus = trapFocus;

    function trapFocus(e) {
      if (e.key !== 'Tab') return;
      const focusable = popup.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      );
      const first = focusable[0];
      const last  = focusable[focusable.length - 1];

      if (e.shiftKey) {
        if (document.activeElement === first) { e.preventDefault(); last.focus(); }
      } else {
        if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
      }
    }
  }

  function closePopup(popup) {
    if (!popup) return;
    popup.setAttribute('hidden', '');
    body.style.overflow = '';
    if (popup._trapFocus) popup.removeEventListener('keydown', popup._trapFocus);

    // Returner fokus til trigger-elementet
    const trigger = document.querySelector(`[data-popup="${popup.id}"]`);
    trigger?.focus();
  }

  // Åpne popup via kort-klikk
  document.querySelectorAll('[data-popup]').forEach(trigger => {
    trigger.addEventListener('click', () => openPopup(trigger.dataset.popup));
    trigger.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openPopup(trigger.dataset.popup);
      }
    });
  });

  // Lukk via X-knapp
  document.querySelectorAll('.ansatt-popup__close').forEach(btn => {
    btn.addEventListener('click', () => closePopup(btn.closest('.ansatt-popup')));
  });

  // Lukk via backdrop-klikk
  document.querySelectorAll('.ansatt-popup__backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', () => closePopup(backdrop.closest('.ansatt-popup')));
  });

  // Lukk via Escape
  document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    const open = document.querySelector('.ansatt-popup:not([hidden])');
    if (open) closePopup(open);
  });

})();
