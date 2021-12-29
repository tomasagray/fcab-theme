$(window).load(function () {

    $('.quick-jump-button').on('click', function (e) {
        e.preventDefault();
        let href = $(this).attr('href');
        let menuOffset = $('#menu-wrapper').height();
        let scrollTo = $(href).offset().top - menuOffset;

        $('html, body').animate({
            scrollTop: scrollTo
        }, 500);
    });

    $('.scroll-top-button').on('click', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

    // show or hide scroll top button depending on current position
    $(window).scroll(function () {
        let viewHeight = $(window).height();
        let showLimit = viewHeight * 0.6;
        let pos = $(this).scrollTop();

        if (pos > showLimit) {
            $('.scroll-top-button').stop(true).animate({
                opacity: 100
            }, 500);
        } else {
            $('.scroll-top-button').stop(true).animate({
                opacity: 0
            }, 250);
        }
    });
})
