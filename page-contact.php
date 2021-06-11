<?php

namespace fcab\theme;

use WP_Query;

const POST_TYPE = 'fcab_cpt_volunteer';
const VOLUNTEER_QUOTES = 3;

get_header();

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

    <div id="about-header-image" class="hero-header-image"
         style="background-image: url('<?php echo $thumbnail; ?>');"></div>

    <div class="content-box hero">
        <div class="hero-header-container">
            <div class="hero-header-text">
                <h1>Contact Us</h1>
<!--                <p>--><?php //echo get_the_excerpt(get_the_ID()); ?><!--</p>-->
            </div>
        </div>

        <div id="contact-form">
            <style>
                .fusion-one-half {
                    width: 100%;
                }

                .fusion-separator {
                    display: none;
                }

                .fusion-column-last {
                    display: none;
                }
            </style>
            <?php the_content(); ?>
        </div>

        <div class="volunteer-quotes-container">
            <?php
            // get volunteer quotes
            $q_args = [
                'post_type' => POST_TYPE,
                'post_status' => 'publish',
                'posts_per_page' => VOLUNTEER_QUOTES,
                'order' => 'DESC',
                'orderby' => 'date'
            ];
            $query = new WP_Query($q_args);
            while ($query->have_posts()): $query->the_post(); ?>
                <div class="volunteer-quote-container">
                    <?php the_post_thumbnail('medium', array('class' => 'volunteer-portrait')); ?>
                    <div class="volunteer-quote-data">
                        <p class="volunteer-quote-text">
                            <?php
                            $quote = get_the_excerpt();
                            $quote = '"' . $quote . '"';
                            echo $quote;
                            ?>
                        </p>
                        <p>- <?php the_title(); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
get_footer();
