<?php

namespace fcab\theme;

global $wp_query;

get_header();
?>
    <div class="content-box">
        <?php the_content(); ?>
    </div>
    <?php
print_pagination_container($wp_query);
get_footer();
