jQuery(function ($) {
    'use strict';

	jQuery(document).on('ready', function () {

         // Header Sticky
		$(window).on('scroll',function() {
			if ($(this).scrollTop() > 30){  
				$('.navbar').addClass("is-sticky");
			}
			else{
				$('.navbar').removeClass("is-sticky");
			}
		});

        // Offcanvas Responsive Menu
		const list = document.querySelectorAll('.offcanvas-body .menu-item');
		function accordion(e) {
			e.stopPropagation(); 
			if(this.classList.contains('active')){
				this.classList.remove('active');
			}
			else if(this.parentElement.parentElement.classList.contains('active')){
				this.classList.add('active');
			}
			else {
				for(let j=0; j < list.length; j++){
					list[j].classList.remove('active');
				}
				this.classList.add('active');
			}
		}
		for(let j = 0; j < list.length; j++ ){
			list[j].addEventListener('click', accordion);
		}

        // Go to Top
		$(function(){
			// Scroll Event
			$(window).on('scroll', function(){
				var scrolled = $(window).scrollTop();
				if (scrolled > 300) $('#backtotop').addClass('active');
				if (scrolled < 300) $('#backtotop').removeClass('active');
			});

			// Click Event
			$('#backtotop').on('click', function() {
				$("html, body").animate({ scrollTop: "0" },  500);
			});
		});

        window.onload = function(){

            // Check if elements with the class "search-toggler" exist
            const searchTogglers = document.querySelectorAll(".search-toggler");
                if (searchTogglers.length > 0) {
                // Attach a click event listener to each "search-toggler" element
                searchTogglers.forEach((searchToggler) => {
                    searchToggler.addEventListener("click", function (e) {
                    e.preventDefault();
                    
                    // Toggle the class "active" on elements with the class "search-popup"
                    const searchPopup = document.querySelector(".search-popup");
                    if (searchPopup) {
                        searchPopup.classList.toggle("active");
                    }

                    // Remove the class "expanded" from elements with the class "mobile-nav__wrapper"
                    const mobileNavWrapper = document.querySelector(".mobile-nav-wrapper");
                    if (mobileNavWrapper) {
                        mobileNavWrapper.classList.remove("expanded");
                    }
                    });
                });
            }

            // Preloader
            const getPreloaderId = document.getElementById('preloader');
            if (getPreloaderId) {
                getPreloaderId.style.display = 'none';
            }

            // Counter Js
            try {
                if ("IntersectionObserver" in window) {
                    let counterObserver = new IntersectionObserver(function (entries, observer) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                            let counter = entry.target;
                            let target = parseInt(counter.innerText);
                            let step = target / 200;
                            let current = 0;
                            let timer = setInterval(function () {
                                current += step;
                                counter.innerText = Math.floor(current);
                                if (parseInt(counter.innerText) >= target) {
                                clearInterval(timer);
                                }
                            }, 10);
                            counterObserver.unobserve(counter);
                            }
                        });
                    });

                    let counters = document.querySelectorAll(".counter");
                        counters.forEach(function (counter) {
                        counterObserver.observe(counter);
                    });
                }
            } catch {}
            
        };

        // Feedback Style Swiper JS
        var SwiperTraveler = new Swiper(".feedback-style-slider", {
            loop: true,
            spaceBetween: 25,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".feedback-style-button-next",
                prevEl: ".feedback-style-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 2
                },
            }
        });

    });

    $( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
    
            // Main Slider JS
            var swiper = new Swiper(".main-slider", {
                effect: "fade",
                loop: true,
                grabCursor: true,
                spaceBetween: 25,
                speed: 1200,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".main-slider-pagination",
                    type: "fraction",
                },
            });

            // Case Study Swiper JS
            var SwiperTraveler = new Swiper(".case-study-slider", {
                loop: true,
                spaceBetween: 25,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".case-study-button-next",
                    prevEl: ".case-study-button-prev",
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    992: {
                        slidesPerView: 2
                    },
                    1200: {
                        slidesPerView: 3
                    },
                }
            });

            // Feedback Slider JS
            var swiper = new Swiper(".feedback-slider", {
                loop: true,
                spaceBetween: 25,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".feedback-button-next",
                    prevEl: ".feedback-button-prev",
                },
            });

            // Client Swiper JS
            var SwiperTraveler = new Swiper(".client-slider", {
                loop: true,
                spaceBetween: 25,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2
                    },
                    576: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 5
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 5
                    },
                }
            });

            // Case Study Swiper JS
            var SwiperTraveler = new Swiper(".case-study-style-slider", {
                loop: true,
                spaceBetween: 25,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".case-study-style-button-next",
                    prevEl: ".case-study-style-button-prev",
                },
                scrollbar: {
                    el: ".swiper-scrollbar",
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 1
                    },
                    992: {
                        slidesPerView: 1
                    },
                    1200: {
                        slidesPerView: 2
                    },
                }
            });

          
            var SwiperTraveler = new Swiper(".feedback-style-wrap-slider", {
                loop: true,
                spaceBetween: 25,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".feedback-style-button-next",
                    prevEl: ".feedback-style-button-prev",
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    992: {
                        slidesPerView: 2
                    },
                    1200: {
                        slidesPerView: 3
                    },
                }
            });

            // scrollCue
            scrollCue.init();

        });
	});
        
}(jQuery));   