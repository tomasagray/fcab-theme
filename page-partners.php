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
            margin: 2rem 0;
            font-size: 14pt;
            text-align: center;
        }

        .major-donor-sub > strong {
            color: #17458E;
        }
    </style>
    <div class="content-box">
        <?php the_content(); ?>
    </div>
    <?php
get_footer();
