<?php

namespace fcab\theme;

use WP_Query;

const FCAB_PROJECT_TAG = 'fcab_project_tag';
const CAROUSEL_PROJECT_COUNT = 6;


get_header();

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

// Get projects
$loop = new WP_Query([
    'post_type' => 'fcab_cpt_project',
    'post_status' => 'publish',
    'posts_per_page' => 6
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
        <div id="project-carousel-container" class="fcab-carousel-container">
        </div>
            <script>
                $(document).ready(function(){
                    $('.fcab-carousel').slick({
                        infinite: true,
                        arrows: true,
                        dots: true,
                        centerMode: true,
                        slidesToShow: 3,
                        slidesToScroll: 3
                    });
                });
            </script>

            <h2 style="text-align: center;">Current Projects</h2>

            <div class="fcab-carousel" id="main-page-project-carousel">
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
    <?php
get_footer();
