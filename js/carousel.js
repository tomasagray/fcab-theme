/**
 * Class which turns a <div> into an animated carousel
 */
class Carousel {
    carousel;
    wrapper;
    items;
    advance;
    prevButton;
    nextButton;

    constructor(carousel) {
        this.carousel = carousel;
        this.wrapper = carousel.find('.carousel-item-wrapper');
        this.items = this.wrapper.children();
        this.advance = $(this.items[0]).outerWidth(true);
        this.setupButtons();
    }

    moveCarousel($direction = 'left') {
        let $carousel = this.carousel;
        let $wrapper = this.wrapper;
        let $advance = this.advance;
        let $items = this.items;
        let $prevButton = this.prevButton;
        let $nextButton = this.nextButton;

        return function () {
            // todo - refactor, separate concerns: evaluation, rendering, etc.
            let $multiplier = 1;
            let $current = $wrapper.css('left');
            let $currentLeft = parseInt($current.substr(0, $current.lastIndexOf('px')));
            if ($direction !== 'right' && $currentLeft === 0) {
                console.log('Carousel at max left');
                $prevButton.addClass('disabled');
                return;
            }
            if ($direction === 'right') {
                let $carouselRightEdge = $($carousel).offset().left + $($carousel).outerWidth();
                let $lastItem = $($items.slice(-1)[0]);
                let $lastItemRightEdge = $lastItem.offset().left + $lastItem.outerWidth();
                if ($lastItemRightEdge <= $carouselRightEdge) {
                    console.log('Carousel at max right');
                    $nextButton.addClass('disabled');
                    return;
                }
                $multiplier = -1;
                $prevButton.removeClass('disabled');
            } else {
                $nextButton.removeClass('disabled');
            }
            let $move = $currentLeft + ($multiplier * $advance);
            $wrapper.animate({left: $move + 'px'});
        }
    }

    setupButtons() {
        this.prevButton = this.carousel.children('.carousel-prev-button');
        this.nextButton = this.carousel.children('.carousel-next-button');
        console.log('Attaching Carousel.js button functionality to', this.prevButton, this.nextButton);
        this.prevButton.on('click', this.moveCarousel());
        this.prevButton.addClass('disabled');
        this.nextButton.on('click', this.moveCarousel('right'));
    }
}
