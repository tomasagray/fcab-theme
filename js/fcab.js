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

class Carousel {
    carousel;
    wrapper;
    items;
    advance;

    constructor(carousel) {
        this.carousel = carousel;
        this.wrapper = carousel.children('.fcab-carousel-item-wrapper');
        this.items = this.wrapper.children();
        this.advance = $(this.items[0]).outerWidth(true);
    }

    moveCarousel($direction = 'left') {
        let $carousel = this.carousel;
        let $wrapper = this.wrapper;
        let $advance = this.advance;
        let $items = this.items;

        // todo - pass ^obj as param
        return function() {
            let $multiplier = 1;
            let $current = $wrapper.css('left');
            let $currentLeft = parseInt($current.substr(0, $current.lastIndexOf('px')));
            if ($direction !== 'right' && $currentLeft === 0) {
                console.log('Carousel at max left')
                return;
            }
            if ($direction === 'right') {
                let $carouselRightEdge = $($carousel).offset().left + $($carousel).outerWidth();
                let $lastItem = $($items.slice(-1)[0]);
                let $lastItemRightEdge = $lastItem.offset().left + $lastItem.outerWidth();
                if ($lastItemRightEdge <= $carouselRightEdge) {
                    console.log('Carousel at max right');
                    return;
                }
                $multiplier = -1;
            }
            let $move = $currentLeft + ($multiplier * $advance);
            $wrapper.animate({left: $move + 'px'});
        }
    }
}
