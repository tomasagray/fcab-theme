<?php

namespace fcab\theme;

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');

get_header();
?>
    <style>
        @media screen and (max-width: 899px) {
            .hero-header-container {
                position: relative;
                top: var(--nav-menu-height);
                margin-bottom: 5rem;
            }
        }
    </style>
    <div class="hero-image-container">
        <div id="about-header-image" class="hero-header-image"
             style="background-image: url('<?php echo $thumbnail; ?>');"></div>
    </div>
    <div class="content-box hero">
        <div class="hero-header-container">
            <div class="hero-header-text">
                <h1>Contact Us</h1>
            </div>
        </div>

        <div id="contact-form">
            <?php the_content(); ?>
        </div>
    <?php
get_footer();
