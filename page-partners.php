<?php

namespace fcab\theme;

get_header();
?>
    <style>
        .fusion-imageframe {
            padding: 2rem;
            border-radius: 1rem;
        }

        .major-donor-sub {
            display: flex;
            align-items: center;
        }

        .major-donor-sub > img {
            margin: 2rem;
        }
    </style>
    <div class="content-box">
        <?php the_content(); ?>
    </div>
    <?php
get_footer();
