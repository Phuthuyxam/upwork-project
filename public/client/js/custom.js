
$(document).ready(function () {

    // Home slide
    $('.home-slider').slick({
        autoplay: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        lazyLoad: 'progressive',
        autoplaySpeed: 5000,
        vertical: true,
        verticalSwiping: true,
        arrows: true,
        prevArrow: "<div class='btn-prev'><div class='container'><div class='slide-control'><div class='slide-arrow'><div class='diamond'><i class='fas fa-long-arrow-alt-up' aria-hidden='true'></i></div><p>Prev</p></div></div></div></div>",
        nextArrow: "<div class='btn-next'><div class='container'><div class='slide-control'><div class='slide-arrow'><p>Next</p><div class='diamond'><i class='fas fa-long-arrow-alt-down' aria-hidden='true'></i></div></div></div></div></div>"
    })

    $('.brand-slider').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: true,
        autoplaySpeed: 3000,
        autoplay: true,
        arrows: false,
        customPaging: function (slider, i) {
            return '<div class="dot"></div>';
        },
        responsive: [
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    })

    $(".home-slider").on("afterChange", function (event, slick, currentSlide, nextSlide) {
        var dataId = $(slick.$slides[currentSlide]).attr('data-slick-index');
        var index = parseInt(dataId) < 10 ? "0" + (parseInt(dataId) + 1) : (parseInt(dataId) + 1);
        $('#counter-number').text(index);
    })

    // Fixed header
    $(window).scroll(function () {
        var sticky = $('header'),
            scroll = $(window).scrollTop();
        if (scroll >= 100) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
    });

    $('.location-search-wrapper .search-icon').click(function () {
        $(this).parent().find('.search-input').toggleClass('active');
    })

    // menu mobile
    $('.menu-site .overlay .btn-close').click(function () {
        $(this).parents('.menu-site').css('width', '0');
    })
    $('.menu-site .overlay').click(function () {
        $(this).parents('.menu-site').css('width', '0');
    })
    $('.header-content .menu-mobile').click(function () {
        $(this).parents('.header-content').find('.menu-site').css('width', '100%')
    })

    // search form
    $('.date-picker').datepicker({ autoclose: true, format: 'dd M yyyy', startDate: new Date(), todayHighlight: true, orientation: "bottom left" });
    $('.check-in').click(function () {
        $('.start-date').datepicker('show');
    })
    $('.check-out').click(function () {
        $('.end-date').datepicker('show');
    })
    $('.start-date').on('change', function () {
        var date = $(this).val().split(' ');
        $(this).parents('.check-in').find('.date').text(date[0]);
        $(this).parents('.check-in').find('.month-year').text(date[1] + " " + date[2]);
    })
    $('.end-date').on('change', function () {
        var date = $(this).val().split(' ');
        $(this).parents('.check-out').find('.date').text(date[0]);
        $(this).parents('.check-out').find('.month-year').text(date[1] + " " + date[2]);
    })

    // Detail slide
    var totalSlide = $('.detail-slider .slider-nav').find('.item').length;
    var width = $('.detail-slider .slider-nav').width();
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });

    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: true,
        arrows: false,
        centerMode: true,
        focusOnSelect: true,
        customPaging: function (slider, i) {
            return '<div class="dot" style="width:' + (width / totalSlide) + 'px;"></div>';
        }, responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.slider-for .image-zoom').click(function () {
        var src = $(this).parents('.item').find('img.thumb').attr('src');
        $.fancybox.open({
            src: src,
            type: 'image'
        })
    })

    $('.date-input .detail-date-picker').datepicker({ autoclose: true, format: 'yyyy/mm/dd', startDate: new Date(), todayHighlight: true, orientation: "bottom left" });

    // Contact form
    // if ($(window).width() > 540) {
        var contactFormH = $('.contact-form').outerHeight();
        $('.contact-list .item').each(function () {
            $(this).outerHeight((contactFormH - 30) / 2 + 'px');
        })
    // }

});
