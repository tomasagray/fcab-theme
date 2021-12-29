<?php

namespace fcab\theme;

global $wp_query;

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
    <?php
print_pagination_container($wp_query);
get_footer();
