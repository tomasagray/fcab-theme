<?php

namespace fcab\theme;

get_header();
?>
    <div class="content-box">
        <h1><?php the_title(); ?></h1>
        <div class="project-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php
get_footer();

