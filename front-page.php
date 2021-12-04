<?php

namespace fcab\theme;

use WP_Query;


get_header();

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

$args = get_programs_query();
$loop = new WP_Query($args);
$loop->get_posts();
?>
    <div class="hero-image-container">
        <div id="about-header-image" class="hero-header-image"
             style="background-image: url('<?php echo $thumbnail; ?>');"></div>
    </div>
    <div id="homepage-content-box" class="content-box hero">
        <div id="hero-header-container" class="hero-header-container">
            <div class="hero-header-text">
                <h1>Foundation for Charitable Activities in Bangladesh</h1>
            </div>
        </div>
        <?php the_content(); ?>
        <div id="project-carousel-container" class="carousel-container"></div>

        <h1 style="text-align: center;">Activities</h1>
        <div class="carousel-container" id="fcab-carousel-container">
            <div class="carousel-prev-button">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-prev.png" alt="Previous"
                     id="current-project-carousel-prev"/>
            </div>
            <div class="carousel" id="main-page-project-carousel">
                <div class="carousel-item-wrapper">
                    <?php
                    // display latest projects
                    if ($loop->have_posts()):
                        while ($loop->have_posts()): $loop->the_post(); ?>
                            <div class="carousel-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    // get Project featured image, or placeholder
                                    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    if (!$thumbnail) {
                                        $thumbnail = get_template_directory_uri() . '/img/placeholder.png';
                                    }
                                    ?>
                                    <div class="carousel-item-image"
                                         style="background-image: url('<?php echo $thumbnail; ?>');">
                                        &nbsp;
                                    </div>
                                    <h3><?php the_title(); ?></h3>
                                </a>
                            </div>
                        <?php endwhile; ?><?php else: echo "No Activities at this time. Please back soon."; ?><?php endif; ?>
                </div>
            </div>
            <div class="carousel-next-button">
                <img src="<?php echo get_template_directory_uri(); ?>/img/carousel-next.png" alt="Next"
                     id="current-project-carousel-next"/>
            </div>
        </div>
        <script>
            $(function () {
                let elem = $('#fcab-carousel-container');
                let carousel = new Carousel(elem);
                console.log('created Carousel on:', carousel);
            });
        </script>
    </div>
    <?php
get_footer();
