<?php

namespace fcab\theme;

get_header();
?>
    <div class="content-box">
        <?php while (have_posts()): the_post(); ?>
            <div id="post-<?php the_ID(); ?>" class="post-container">
                <div class="post-content-container">
                    <?php
                    $content = apply_filters('the_content', get_the_content());
                    echo $content;
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="pagination-container">
        <div class="nav-previous alignleft"><?php previous_posts_link('Prev.'); ?></div>
        <div class="nav-next alignright"><?php next_posts_link('Next'); ?></div>
    </div>
    <?php
get_footer();
