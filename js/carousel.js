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
    isMoving;

    #setupButtons() {
        this.prevButton = this.carousel.children('.carousel-prev-button');
        this.nextButton = this.carousel.children('.carousel-next-button');
        this.prevButton.on('click', this.handleCarouselMove());
        this.nextButton.on('click', this.handleCarouselMove('right'));
        this.#setButtonState();
    }

    #computeNextMove() {
        let lastItem = $(this.items.slice(-1)[0]);
        let itemWidth = lastItem.outerWidth();
        let carouselRightEdge = $(this.carousel).offset().left + $(this.carousel).outerWidth();
        let lastItemRightEdge = lastItem.offset().left + itemWidth;
        return lastItemRightEdge - carouselRightEdge;
    }

    #computeCurrentLeft() {
        let current = this.wrapper.css('left');
        return parseInt(current.substr(0, current.lastIndexOf('px')));
    }

    #hideButton(button) {
        button.animate({opacity: 0}, 250, function () {
            $(this).addClass('disabled');
        });
    }

    #showButton(button) {
        button.animate({opacity: 1}, 250, function () {
            $(this).removeClass('disabled');
        });
    }

    #setButtonState() {
        let lastItem = $(this.items.slice(-1)[0]);
        let itemWidth = lastItem.outerWidth();
        let currentLeft = this.#computeCurrentLeft();
        let nextMove = this.#computeNextMove();

        if (Math.abs(currentLeft) < itemWidth) {
            this.#hideButton(this.prevButton);
        } else {
            this.#showButton(this.prevButton);
        }
        if (nextMove <= 0) {
            this.#hideButton(this.nextButton);
        } else {
            this.#showButton(this.nextButton);
        }
    }

    #computeMove(direction = 'left') {
        let multiplier = 1;
        let current = this.wrapper.css('left');
        let currentLeft = parseInt(current.substr(0, current.lastIndexOf('px')));
        let lastItem = $(this.items.slice(-1)[0]);
        let itemWidth = lastItem.outerWidth();

        if (direction !== 'right' && currentLeft === 0) {
            return currentLeft;
        }
        if (direction === 'right') {
            let carouselRightEdge = $(this.carousel).offset().left + $(this.carousel).outerWidth();
            let lastItemRightEdge = lastItem.offset().left + itemWidth;
            if (lastItemRightEdge <= carouselRightEdge) {
                return currentLeft;
            }
            multiplier = -1;
        }
        return currentLeft + (multiplier * this.advance);
    }

    constructor(carousel) {
        this.carousel = carousel;
        this.wrapper = carousel.find('.carousel-item-wrapper');
        this.items = this.wrapper.children();
        this.advance = $(this.items[0]).outerWidth(true);
        this.isMoving = false;
        this.#setupButtons();
    }

    handleCarouselMove(direction = 'left') {
        const carousel = this;
        return function () {
            if (carousel.isMoving) {
                return;
            }
            carousel.isMoving = true;
            let move = carousel.#computeMove(direction);
            let wrapper = carousel.wrapper;
            wrapper.animate({left: move + 'px'}, 500, function () {
                carousel.#setButtonState();
                carousel.isMoving = false;
            });
        }
    }
}
