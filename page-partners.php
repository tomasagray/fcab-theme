<?php

namespace fcab\theme;

get_header();
?>
    <style>
        .fusion-imageframe {
            padding: 2rem;
            border-radius: 1rem;
        }

        .major-donor-box {
            display: inline-block;
        }

        .major-donor-sub {
            display: flex;
            flex-flow: column;
            align-items: center;
            justify-content: center;
            margin: 1rem 0;
            border: 3px solid whitesmoke;
            font-size: 16pt;
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
