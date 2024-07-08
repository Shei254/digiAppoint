(function ($) {
  "use strict";


  var $client_slider = $('.client_slider'),
    $popup_video = $('.popup_video');

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {

    // ============== Header Hide Click On Body Js Start ========
    $('.header-button').on('click', function () {
      $('.body-overlay').toggleClass('show')
    });
    $('.body-overlay').on('click', function () {
      $('.header-button').trigger('click')
      $(this).removeClass('show');
    });
    // =============== Header Hide Click On Body Js End =========

    // ========================== Header Hide Scroll Bar Js Start =====================
    $('.navbar-toggler.header-button').on('click', function () {
      $('body').toggleClass('scroll-hide-sm')
    });
    $('.body-overlay').on('click', function () {
      $('body').removeClass('scroll-hide-sm')
    });
    // ========================== Header Hide Scroll Bar Js End =====================

    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js Start =====================
    $('.dropdown-item').on('click', function () {
      $(this).closest('.dropdown-menu').addClass('d-block')
    });
    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js End =====================

    // ========================== Add Attribute For Bg Image Js Start =====================
    $(".bg-img").css('background', function () {
      var bg = ('url(' + $(this).data("background-image") + ')');
      return bg;
    });

    // ================== Password Show Hide Js Start ==========
    $(".toggle-password").on('click', function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    // =============== Password Show Hide Js End =================

    // ========================= Owl Carousel Slider Js Start ==============

    // Owl Carousel For Clients
    if ($client_slider.length > 0) {
      var $client_slider_obj = $client_slider.owlCarousel({
        autoplay: false,
        margin: 40,
        loop: false,
        nav: false,
        dots: false,
        items: 6,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            margin: 0
          },
          375: {
            items: 2,
            margin: 15
          },
          425: {
            items: 3,
            margin: 20
          },
          576: {
            items: 4,
          },
          768: {
            items: 4,
            margin: 30
          },
          992: {
            items: 5,
            margin: 30
          },
          1200: {
            items: 6,
            margin: 35
          },
          1400: {
            margin: 40
          }
        }
      });
    };
    // ========================= Owl Carousel Slider Js End ===================

    // ========================= Video Pupup Js End ===================
    if ($popup_video.length > 0) {
      $popup_video.lightcase({
        transition: 'elastic',
        controls: true,
      });
    }
    // ========================= Video Pupup Js End ===================

    // ================== Sidebar Menu Js Start ===============
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on("click", function () {
      $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".has-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
    });
    // Sidebar Dropdown Menu End
    // Sidebar Icon & Overlay js 
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass('show-sidebar');
      $(".sidebar-overlay").addClass('show');
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass('show-sidebar');
      $(".sidebar-overlay").removeClass('show');
    });
    // Sidebar Icon & Overlay js 
    // ===================== Sidebar Menu Js End =================

    // ==================== Dashboard User Profile Dropdown Start ==================

    // User Dropdown
    $('.user-info__button').on('click', function () {
      $('.user-info-dropdown').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.user-info__button').length && !target.closest('.user-info-dropdown').length) {
        $('.user-info-dropdown').removeClass('show');
      }
    });

    // Notification Dropdown
    $('.notification__button').on('click', function () {
      $('.notification__dropdown').toggleClass('show');
    });

    $(document).on('click', function (event) {
      var target = $(event.target);

      if (!target.closest('.notification__button').length && !target.closest('.notification__dropdown').length) {
        $('.notification__dropdown').removeClass('show');
      }
    });

    // Dashboard Search
    $('.dashboard-search__button').on('click', function () {
      $(this).toggleClass('change-icon');
      $('.dashboard-search__form').toggleClass('show');
    });


    // ==================== Dashboard User Profile Dropdown End ==================

    // ==================== Custom Sidebar Dropdown Menu Js Start ==================
    $('.has-submenu').on('click', function (event) {
      event.preventDefault(); // Prevent the default anchor link behavior

      // Check if this submenu is currently visible
      var isOpen = $(this).find('.sidebar-submenu').is(':visible');

      // Hide all submenus initially
      $('.sidebar-submenu').slideUp();

      // Remove the "active" class from all li elements
      $('.sidebar-menu__item').removeClass('active');

      // If this submenu was not open, toggle its visibility and add the "active" class to the clicked li
      if (!isOpen) {
        $(this).find('.sidebar-submenu').slideToggle(500);
        $(this).addClass('active');
      }
    });
    // ==================== Custom Sidebar Dropdown Menu Js End ==================

    // ========================= Odometer Counter Up Js End ==========
    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
            var el = document.querySelectorAll('.odometer')[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });
    // ========================= Odometer Up Counter Js End =====================

  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $('.preloader').fadeOut();
  })
  // ========================= Preloader Js End=====================

  // ========================= Header Sticky Js Start ==============
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= 300) {
      $('.header').addClass('fixed-header');
    }
    else {
      $('.header').removeClass('fixed-header');
    }
  });
  // ========================= Header Sticky Js End===================

  //============================ Scroll To Top Icon Js Start =========
  var btn = $('.scroll-top');

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });
  //========================= Scroll To Top Icon Js End ======================

})(jQuery);


let elements = document.querySelectorAll('[data-s-break]');
Array.from(elements).forEach(element => {
  let html = element.innerHTML;
  if (typeof html != 'string') { return false; } let breakLength = parseInt(element.getAttribute('data-s-break')); html = html.split(" ");
  var colorText = [];
  if (breakLength < 0) { colorText = html.slice(breakLength); } else { colorText = html.slice(0, breakLength); }
  let solidText = [];
  html.filter(ele => { if (!colorText.includes(ele)) { solidText.push(ele); } });
  var color = element.getAttribute('s-color') || "text--base";
  colorText = `<span class="${color}">${colorText.toString().replaceAll(',', ' ')}</span>`; solidText = solidText.toString().replaceAll(',', ' ');
  breakLength < 0 ? element.innerHTML = `${solidText} ${colorText}` : element.innerHTML = `${colorText} ${solidText}`
});