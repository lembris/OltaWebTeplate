/**
 * Template Name: Clinic
 * Template URL: https://bootstrapmade.com/clinic-bootstrap-template/
 * Updated: Jul 23 2025 with Bootstrap v5.3.7
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */

(function () {
  "use strict";

  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });
  });

  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function (e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  new PureCounter();

  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
      const swiperConfig = swiperElement.querySelector(".swiper-config");
      if (!swiperConfig) return;
      
      let config = JSON.parse(
        swiperConfig.innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

})();

// Consultation Form - Normal Form Submission
document.addEventListener('DOMContentLoaded', function () {
  const consultationForm = document.getElementById('consultationForm');
  
  if (!consultationForm) return;
  
  function clearErrors() {
    document.querySelectorAll('.error-message').forEach(el => {
      el.textContent = '';
    });
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
      el.style.borderColor = '#e2e8f0';
    });
  }
  
  const fieldsToValidate = ['fullName', 'country', 'phone', 'email', 'medical_speciality', 'treatment'];
  
  fieldsToValidate.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    if (field) {
      field.addEventListener('input', function () {
        const errorElement = document.getElementById(fieldId + '_error');
        if (errorElement) {
          errorElement.textContent = '';
        }
        this.style.borderColor = '#e2e8f0';
      });
    }
  });
  
  consultationForm.addEventListener('submit', function (e) {
    let isValid = true;
    clearErrors();
    
    const requiredFields = [
      { id: 'fullName', name: 'Full Name' },
      { id: 'email', name: 'Email Address' },
      { id: 'country', name: 'Country' },
      { id: 'phone', name: 'Phone Number' },
      { id: 'medical_speciality', name: 'Medical Specialty' },
      { id: 'treatment', name: 'Treatment Timeline' }
    ];
    
    requiredFields.forEach(field => {
      const input = document.getElementById(field.id);
      const errorElement = document.getElementById(field.id + '_error');
      
      if (!input || !input.value.trim()) {
        if (errorElement) errorElement.textContent = field.name + ' is required';
        if (input) input.style.borderColor = '#ef4444';
        isValid = false;
      } else {
        input.style.borderColor = '';
        
        if (field.id === 'email') {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(input.value.trim())) {
            if (errorElement) errorElement.textContent = 'Please enter a valid email address';
            input.style.borderColor = '#ef4444';
            isValid = false;
          }
        }
        
        if (field.id === 'phone') {
          const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
          if (!phoneRegex.test(input.value.trim())) {
            if (errorElement) errorElement.textContent = 'Please enter a valid phone number';
            input.style.borderColor = '#ef4444';
            isValid = false;
          }
        }
      }
    });
    
    if (!isValid) {
      e.preventDefault();
    }
  });
});
