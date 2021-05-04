<?php
/**
 * single.php - Display single posts
 */

namespace fcab\theme;


get_header();
?>

<div id="content-container">
    <?php while (have_posts()): the_post(); ?>
    <div id="post-<?php the_ID(); ?>" class="post-container">
        <h2><?php the_title(); ?></h2>
    </div>
</div>

<?php
endwhile;
get_footer();
?>
