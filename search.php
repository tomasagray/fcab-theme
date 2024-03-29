<?php

namespace fcab\theme;

const SEARCH_EXCERPT_LEN = 35;

function get_result_excerpt($content): string
{
    $do_shortcode = do_shortcode($content);
    $text = apply_filters('the_content', $do_shortcode);
    // remove styles
    $styleless = preg_replace('/<style((.|\n|\r)*?)<\/style>/', '', $text);
    $excerpt = strip_tags($styleless);

    $words = explode(' ', $excerpt, SEARCH_EXCERPT_LEN);
    if (count($words) >= SEARCH_EXCERPT_LEN) {
        array_pop($words);
        $words[] = '...';
    }
    return implode(' ', $words);
}

global $wp_query;

get_header();
?>
    <div class="content-box">
        <h1 style="margin-bottom: 0;">Search results</h1>
        <p style="color: #ccc; font-size: small">
            Searching for:
            <span style="color: #aaa">
                <?php the_search_query(); ?>
            </span>
        </p>
        <p>Total results: <?php echo $wp_query->found_posts; ?></p>

        <div class="search-results-container">
            <?php
            $posts = $wp_query->get_posts();
            foreach ($posts as $post):
                setup_postdata($post->ID);
                $url = $post->guid;
                ?>
                <div class="search-result-container">
                    <a href="<?php echo $url; ?>" class="search-result-title">
                        <?php echo $post->post_title; ?>
                    </a>
                    <a href="<?php echo $url; ?>" class="search-result-link">
                        <?php echo $url; ?>
                    </a>
                    <p class="search-result-excerpt">
                        <?php echo get_result_excerpt($post->post_content); ?>
                    </p>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <div class="nav-previous alignleft"><?php previous_posts_link('&laquo; Prev.'); ?></div>
    <div class="nav-next alignright"><?php next_posts_link('Next &raquo;'); ?></div>
    <?php
get_footer();
