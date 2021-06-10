<?php

namespace fcab\theme;

use WP_Query;

get_header();

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

?>

    <div id="about-header-image" class="hero-header-image" style="background-image: url('<?php echo $thumbnail; ?>');">
        &nbsp;
    </div>

    <div class="content-box hero">
        <div id="mission-statement" class="hero-header-container">
            <div class="hero-header-text">
                <h1>Foundation for Charitable Activities in Bangladesh</h1>
                <h3 class="hero-header-subtext">Who are we?</h3>
            </div>

            <?php the_content(); ?>

            <div id="about-child-page-container">
                <?php
                $args = array(
                    'post_type' => 'page',
                    'posts_per_page' => -1,
                    'post_parent' => get_the_ID(),
                    'order' => 'ASC',
                    'orderby' => 'menu_order'
                );
                $children = new WP_Query($args);
                if ($children->have_posts()): ?><?php while ($children->have_posts()) : $children->the_post(); ?>
                    <div class="child-page">
                        <div class="child-page-image"
                             style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
                            &nbsp;
                        </div>
                        <div class="child-page-excerpt-container">
                            <div class="child-page-excerpt">
                                <h2 class="excerpt-title"> <?php echo the_title(); ?> </h2>
                                <p class="child-page-excerpt-text"> <?php echo wp_strip_all_tags(get_the_excerpt(), true); ?> </p>
                                <a href="<?php the_permalink(); ?>" class="learn-more-button">Learn More</a>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?><?php endif; ?>
            </div>
        </div>
    </div>

<?php
get_footer();
