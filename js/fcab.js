let openMobileMenu = function ($menu, $openButton, $closeButton) {
    $menu.css('display', 'flex');

    $menu.animate({
        opacity: 1
    }, 500, function () {
        // animation complete
    });

    $openButton.animate({
        opacity: 0
    }, 250, function (){
        $openButton.css('display', 'none');
        $closeButton.css('display', 'block');
    });
    $closeButton.delay(250).animate({
        opacity: 1
    }, 250, function () {});
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
    }, 250, function() {});
};
