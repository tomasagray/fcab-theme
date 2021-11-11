// Mobile menu handling
// ====================================

let openMobileMenu = function ($menu, $openButton, $closeButton) {
    $menu.css('display', 'flex');

    $menu.animate({
        opacity: 1
    }, 500, function () {
        // animation complete
    });

    $openButton.animate({
        opacity: 0
    }, 250, function () {
        $openButton.css('display', 'none');
        $closeButton.css('display', 'block');
    });
    $closeButton.delay(250).animate({
        opacity: 1
    }, 250, function () {
    });
};

let closeMobileMenu = function ($menu, $openButton, $closeButton) {
    $menu.animate({
        opacity: 0
    }, 500, function () {
        $menu.css('display', 'none');
    });

    $closeButton.animate({
        opacity: 0
    }, 250, function () {
        $closeButton.css('display', 'none');
        $openButton.css('display', 'block');
    });
    $openButton.delay(250).animate({
        opacity: 1
    }, 250, function () {
    });
};

let handleMenuClick = function () {
    $menu = $('#menu-outer-container');
    $openButton = $('#mobile-menu-button');
    $closeButton = $('#mobile-menu-close-button');

    if ($menu.css('display') === 'none') {
        openMobileMenu($menu, $openButton, $closeButton);
    } else {
        closeMobileMenu($menu, $openButton, $closeButton);
    }
};

let initializeMobileMenu = function () {

    $('#nav-main-menu').menu({
        classes: {
            'ui-menu': 'nav-main-menu',
            'ui-menu-item': 'menu-item',
        },
        position: {my: 'center bottom', at: 'center top'}
    });

    // Attach mobile menu button handlers
    $('img.mobile-submenu-arrow').on('click', function () {
        let submenu = $(this).parent().siblings().select('ul').first();
        if (submenu.hasClass('open')) {
            submenu.removeClass('open');
            $(this).css('transform', 'rotate(0deg)')
            submenu.animate({height: 0});
        } else {
            submenu.addClass('open');
            $(this).css('transform', 'rotate(90deg)')
            submenu.animate({
                height: submenu.prop('scrollHeight')
            }, 500, function () {
                submenu.css('position', 'initial');
            });
        }
    });
    $('#mobile-menu-button').on('click', function () {
        handleMenuClick();
    });
    $('#mobile-menu-close-button').on('click', function () {
        handleMenuClick();
    });
};
