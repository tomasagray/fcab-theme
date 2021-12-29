<?php

namespace fcab\theme;

require_once 'functions.php';

global $wp_query;

get_header();
?>
    <div class="content-box">
        <?php
        while (have_posts()): the_post();
            the_content();
        endwhile;
        ?>
    </div>
    <?php
print_pagination_container($wp_query);
get_footer();
