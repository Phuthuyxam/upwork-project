const locations = [
    {
        name: 'Frontel Al Harithia Hotel',
        image: 'images/Mask Group 21.png',
        address: '123 abc def',
        city: 'Medina',
        rate: 5,
        location: { lat: -31.56391, lng: 147.154312 }
    },
    {
        name: 'Frontel Al Hotel',
        image: 'images/Mask Group 21.png',
        address: '123 abc def',
        city: 'London',
        rate: 3,
        location: { lat: -32.56391, lng: 147.154312 }
    }
];

$(document).ready(function () {
    $('.lazy').Lazy({
        // your configuration goes here
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        effectTime: 1000,
        threshold: 200,
        visibleOnly: true,
        onError: function (element) {
            console.log('error loading ' + element.data('src'));
        }
    });

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
    $('.location-detail-wrapper .close').click(function (e) {
        e.preventDefault();
        $(this).parents('.location-detail-wrapper').removeClass('animate__slideInLeft');
        $(this).parents('.location-detail-wrapper').addClass('animate__slideOutLeft');
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
function initMap() {
    const maxZoom = 15;
    const minZoom = 3;
    var zoom = 4;
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: zoom,
        center: { lat: -28.024, lng: 140.887 },
        mapTypeControlOptions: { mapTypeIds: [] },
        fullscreenControl: false,
        streetViewControl: false,
        maxZoom: maxZoom,
        minZoom: minZoom,
        zoomControl: false
    });

    google.maps.event.addListener(map, 'zoom_changed', function () {
        zoom = map.getZoom();
        var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
        $('.zoom-controls').find('.zoom-level').height(height);
    });

    const input = document.getElementById("search");
    const searchBox = new google.maps.places.SearchBox(input);
    const infowindow = new google.maps.InfoWindow();
    const infowindowContent = document.getElementById("infowindow-content");


    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
        map.setZoom(maxZoom);

    });

    const markers = locations.map((location, i) => {
        var marker = new google.maps.Marker({
            position: location.location,
            icon: "images/Group 3219.png",
            map: map
        });

        marker.addListener("click", () => {
            if ($(window).width() < 600) {
                html = `
                    <p class="fw-bold">`+ location.name + `</p>
                    <p>`+ location.address + `</p>
                    <p>`+ location.city + `</p>
                `;
                infowindow.setContent(html);
                infowindow.open(map, marker);
            } else {
                map.setZoom(maxZoom);
                map.setCenter(marker.getPosition());

                var rate = "";
                var star = '<i class="fas fa-star"></i>';
                for (var i = 0; i < location.rate; i++) {
                    rate += star;
                }
                $('#location').show();
                $('#location').addClass('animate__animated');
                $('#location').addClass('animate__slideInLeft');
                $('#location').removeClass('animate__slideOutLeft');
                $('#location').find('img').attr('src', location.image);
                $('#location').find('.name').text(location.name);
                $('#location').find('.city').text(location.city);
                $('#location').find('.rate').html(rate);
            }
        });
    });
    $('.zoom-controls .zoom-level').height((zoom - minZoom) / (maxZoom - minZoom) * 100 + '%');
    $('.zoom-controls .plus').click(function () {
        if (zoom < maxZoom) {
            zoom = zoom + 1;
            map.setZoom(zoom);
            var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
            $(this).parents('.zoom-controls').find('.zoom-level').height(height);
        } else {
            zoom = maxZoom;
        }
    })

    $('.zoom-controls .minus').click(function () {
        if (zoom > minZoom) {
            zoom = zoom - 1;
            map.setZoom(zoom);
            var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
            $(this).parents('.zoom-controls').find('.zoom-level').height(height);
        } else {
            zoom = minZoom;
        }

    })
}
