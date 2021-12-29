<?php

namespace fcab\theme;

use WP_Query;

require_once 'functions.php';

get_header();
?>
    <div class="content-box">
        <h1 class="centered-heading">Programs</h1>
        <?php
        $args = get_programs_query();
        $loop = new WP_Query($args);
        if ($loop->have_posts()): ?>
            <div class="project-card-container">
                <?php print_project_cards($loop); ?>
            </div>
            <?php print_pagination_container($loop); ?><?php else:
            echo '<p>There are currently no programs. Please check back soon.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <?php
get_footer();
