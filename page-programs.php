<?php

namespace fcab\theme;

use WP_Query;

require_once 'functions.php';

const PROGRAMS_CPT = 'fcab_cpt_program';
const PROGRAMS_DISPLAYED = 6;


/**
 * @return array
 */
function get_query_args(): array
{
// for pagination
    $page_num = get_page_num();
    return [
        'post_type' => PROGRAMS_CPT,
        'post_status' => 'publish',
        'posts_per_page' => PROGRAMS_DISPLAYED,
        'paged' => $page_num,
        'order' => 'DESC',
        'orderby' => 'date'
    ];
}

get_header();

$args = get_query_args();
$loop = new WP_Query($args);
?>

    <div class="content-box">
        <h1 class="centered-heading">Programs</h1>
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
            echo '<p>There are currently no programs. Please check back soon.</p>';
        endif;
        ?>
    </div>

    <?php

get_footer();
