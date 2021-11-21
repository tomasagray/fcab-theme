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
            <?php print_pagination_container($loop); ?>
        <?php else:
            echo '<p>There are currently no Activities. Please check back soon.</p>';
        endif;
        ?>
    </div>

    <?php

get_footer();
