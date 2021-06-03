<?php

namespace fcab\theme;

use WP_Query;

const FCAB_PROJECT = 'fcab_cpt_project';
const CAROUSEL_PROJECT_COUNT = 6;


get_header();

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

// Get projects
$loop = new WP_Query([
    'post_type' => FCAB_PROJECT,
    'post_status' => 'publish',
    'posts_per_page' => CAROUSEL_PROJECT_COUNT
]);
$projects = $loop->get_posts();
?>
    <div id="about-header" class="hero-header-image" style="background-image: url('<?php echo $thumbnail; ?>');">
        &nbsp;
    </div>
    <div id="homepage-content-box" class="content-box hero">
        <div id="hero-header-container" class="hero-header-container">
            <div class="hero-header-text">
                <h1>Foundation for Charitable Activities in Bangladesh</h1>
            </div>
        </div>
        <?php the_content(); ?>
        <div id="project-carousel-container" class="fcab-carousel-container"></div>

        <h1 style="text-align: center;">Current Projects</h1>

        <div class="fcab-carousel-container">
            <div class="fcab-carousel-prev-button">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-prev.png" alt="Previous"
                     id="current-project-carousel-prev" class="fcab-carousel-prev"/>
            </div>
            <div class="fcab-carousel" id="main-page-project-carousel">
                <div class="fcab-carousel-item-wrapper">
                    <?php
                    // display latest projects
                    while ($loop->have_posts()): $loop->the_post(); ?>
                        <div class="fcab-carousel-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                // get Project featured image, or placeholder
                                $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                if (!$thumbnail) {
                                    $thumbnail = get_template_directory_uri() . '/img/placeholder.png';
                                }
                                ?>
                                <div class="fcab-carousel-image" style="background-image: url('<?php echo $thumbnail; ?>');">
                                    &nbsp;
                                </div>
                                <h3><?php the_title(); ?></h3>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="fcab-carousel-next-button">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-next.png" alt="Next"
                     id="current-project-carousel-next" class="fcab-carousel-next"/>
            </div>
        </div>
        <script>
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

            $(function () {
                let carousel = new Carousel($('#main-page-project-carousel'));
                // todo - move to Carousel class
                $('.fcab-carousel-prev-button').on('click', carousel.moveCarousel());
                $('.fcab-carousel-next-button').on('click', carousel.moveCarousel('right'));
            });
        </script>
    </div>
    <?php
get_footer();
