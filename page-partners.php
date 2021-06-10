<?php

namespace fcab\theme;

get_header();
?>
    <style>
        .fusion-imageframe {
            padding: 2rem;
            border: 2px solid var(--sort-tag-color);
            border-radius: 1rem;
        }
    </style>
    <div class="content-box">
        <?php the_content(); ?>
    </div>
    <?php
get_footer();
