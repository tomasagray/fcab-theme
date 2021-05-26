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
    <div class="hero-header-container">
        <div class="hero-header-text">
            <h1>Contact Us</h1>
            <p><?php echo get_the_excerpt(get_the_ID()); ?></p>
        </div>
    </div>
    <div id="contact-form">
        <?php the_content(); ?>
    </div>
</div>
<?php get_footer(); ?>
