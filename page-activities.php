<?php


namespace fcab\theme;

use WP_Query;

require_once 'functions.php';

get_header();

$args = get_cpt_query(ACTIVITIES_CPT);
$loop = new WP_Query($args);
?>

    <div class="content-box">
        <h1 class="centered-heading">Activities</h1>
        <?php

        if ($loop->have_posts()): ?>
            <div class="project-card-container">
                <?php
                print_project_cards($loop);
                wp_reset_postdata();
                ?>
            </div>
            <div class="pagination-container">
                <div class="nav-previous alignleft">
                    <?php echo get_page_link_html(get_prev_link($loop), '&laquo; Prev.'); ?>
                </div>
                <div class="nav-next alignright">
                    <?php echo get_page_link_html(get_next_link($loop), 'Next 	&raquo;'); ?>
                </div>
            </div>
        <?php else:
            echo '<p>There are currently no Activities. Please check back soon.</p>';
        endif;
        ?>
    </div>

    <?php

get_footer();
