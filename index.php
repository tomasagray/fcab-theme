<?php

namespace fcab\theme;

get_header();
?>

<div id="content-wrapper">
    <div id="content-container">
        <?php while (have_posts()): the_post(); ?>
        <div id="post-<?php the_ID(); ?>" class="post-container">
            <h2><?php the_title(); ?></h2>
            <div class="post-content-container">
                <?php
                $content = apply_filters('the_content', get_the_content());
                echo $content;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;
get_footer();
?>
