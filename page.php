<?php

namespace fcab\theme;

get_header();
?>
    <div class="content-box">
        <?php the_content(); ?>
    </div>

    <div class="pagination-container">
        <div class="nav-previous alignleft"><?php previous_posts_link('Prev.'); ?></div>
        <div class="nav-next alignright"><?php next_posts_link('Next'); ?></div>
    </div>
    <?php
get_footer();