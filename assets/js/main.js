/*!
 * =================================================================
 * Theme Name: Velvet Chili Restaurant Shop
 * Version: 1.0.0
 * Author: Shaik Obydullah
 * Author URI: https://obydullah.com
 * =================================================================
 */

/**
 * INDEX
 * Table of Contents:
 *   1. Mobile Navigation
 *   2. Featured Slider (Hero)
 *   3. Testimonial Carousel
 *   4. Event Slider (About page)
 */

document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  /* ==========================================================================
   1. Mobile Navigation
   ========================================================================== */

  initMobileNav();

  /* ==========================================================================
   2. Featured Slider (Hero)
   ========================================================================== */

  initSlider({
    sliderId: "featuredSlider",
    slideSelector: ".slider__slide",
    dotSelector: ".slider__dot",
    prevBtnId: "sliderPrev",
    nextBtnId: "sliderNext",
    autoplayDelay: 5000,
  });

  /* ==========================================================================
   3. Testimonial Carousel
   ========================================================================== */

  initSlider({
    sliderId: "testimonialCarousel",
    slideSelector: ".testimonial-carousel__slide",
    dotSelector: ".testimonial-carousel__dot",
    prevBtnId: null,
    nextBtnId: null,
    autoplayDelay: 6000,
  });

  /* ==========================================================================
   4. Event Slider (About Page) 
   ========================================================================== */

  initSlider({
    sliderId: "eventSlider",
    slideSelector: ".event-slider__slide",
    dotSelector: ".event-slider__dot",
    prevBtnId: "eventPrev",
    nextBtnId: "eventNext",
    autoplayDelay: 5000,
  });

  /* ---------- Mobile Navigation Implementation  ---------- */

  function initMobileNav() {
    const body = document.body;
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const mobileNav = document.getElementById("mobileNav");
    const mobileLinks = document.querySelectorAll(".mobile-nav__link");
    const mobileBackdrop = document.querySelector(".mobile-nav__backdrop");

    if (!hamburgerBtn || !mobileNav) return;

    function toggleNavigation(force) {
      const isOpen = body.classList.contains("nav--open");
      const shouldOpen = typeof force === "boolean" ? force : !isOpen;

      if (shouldOpen) {
        body.classList.add("nav--open");
        hamburgerBtn.setAttribute("aria-expanded", "true");
        mobileNav.setAttribute("aria-hidden", "false");
        body.style.overflow = "hidden";
      } else {
        body.classList.remove("nav--open");
        hamburgerBtn.setAttribute("aria-expanded", "false");
        mobileNav.setAttribute("aria-hidden", "true");
        body.style.overflow = "";
      }
    }

    hamburgerBtn.addEventListener("click", () => toggleNavigation());

    mobileLinks.forEach((link) => {
      link.addEventListener("click", () => toggleNavigation(false));
    });

    if (mobileBackdrop) {
      mobileBackdrop.addEventListener("click", () => toggleNavigation(false));
    }

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && body.classList.contains("nav--open")) {
        toggleNavigation(false);
      }
    });

    window.addEventListener("resize", () => {
      if (window.innerWidth >= 768 && body.classList.contains("nav--open")) {
        toggleNavigation(false);
      }
    });
  }

  /* ---------- Shared Slider Logic  ---------- */

  function initSlider({
    sliderId,
    slideSelector,
    dotSelector,
    prevBtnId,
    nextBtnId,
    autoplayDelay,
  }) {
    const container = document.getElementById(sliderId);
    if (!container) return;

    const slides = container.querySelectorAll(slideSelector);
    const dots = container.querySelectorAll(dotSelector);
    const prevBtn = prevBtnId ? document.getElementById(prevBtnId) : null;
    const nextBtn = nextBtnId ? document.getElementById(nextBtnId) : null;

    if (!slides.length) return;

    let current = 0;
    let autoplayTimer = null;

    function goTo(index) {
      slides.forEach((s) =>
        s.classList.remove(`${slideSelector.substring(1)}--active`),
      );
      dots.forEach((d) =>
        d.classList.remove(`${dotSelector.substring(1)}--active`),
      );
      slides[index].classList.add(`${slideSelector.substring(1)}--active`);
      if (dots[index])
        dots[index].classList.add(`${dotSelector.substring(1)}--active`);
      current = index;
    }

    function next() {
      goTo((current + 1) % slides.length);
    }

    function prev() {
      goTo((current - 1 + slides.length) % slides.length);
    }

    function startAutoplay() {
      stopAutoplay();
      autoplayTimer = setInterval(next, autoplayDelay);
    }

    function stopAutoplay() {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        next();
        startAutoplay();
      });
    }
    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        prev();
        startAutoplay();
      });
    }

    dots.forEach((dot) => {
      dot.addEventListener("click", function () {
        const idx = parseInt(this.getAttribute("data-slide"), 10);
        if (!isNaN(idx)) {
          goTo(idx);
          startAutoplay();
        }
      });
    });

    container.addEventListener("mouseenter", stopAutoplay);
    container.addEventListener("mouseleave", startAutoplay);
    container.addEventListener("focusin", stopAutoplay);
    container.addEventListener("focusout", startAutoplay);

    let touchStartX = 0;
    container.addEventListener(
      "touchstart",
      (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
      },
      { passive: true },
    );

    container.addEventListener("touchend", (e) => {
      const diff = touchStartX - e.changedTouches[0].screenX;
      if (Math.abs(diff) > 40) {
        diff > 0 ? next() : prev();
      }
      startAutoplay();
    });

    startAutoplay();
  }
});
