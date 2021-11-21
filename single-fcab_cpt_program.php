<?php

namespace fcab\theme;

use WP_Query;

require_once 'functions.php';

get_header();
$title = get_the_title();
?>
<div class="content-box">
<?php if (have_posts()): the_post(); ?>
    <h1><?php echo $title; ?></h1>
    <?php the_content(); ?>
    <div style="height: 5rem;"></div>
    <?php
    $term = get_term_by('name', $title, PROGRAM_TAG);
    if ($term):
        $args = get_cpt_query(ACTIVITIES_CPT, $term);
        $loop = new WP_Query($args);
        if ($loop->have_posts()): ?>
            <h2 class="project-heading">Activities</h2>
            <div class="project-card-container">
                <?php print_project_cards($loop); ?>
            </div>
        <?php endif;

        wp_reset_postdata();

        $args = get_cpt_query(PROJECTS_CPT, $term);
        $loop = new WP_Query($args);
        if ($loop->have_posts()): ?>
            <h2 class="project-heading">Projects</h2>
            <div class="project-card-container">
                <?php print_project_cards($loop); ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php endif; ?>
</div>
<?php
get_footer();
