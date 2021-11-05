<?php

const TAGS = 'fcab_project_tag';

$post_id = url_to_postid($_SERVER['REQUEST_URI']);
$post = get_post($post_id);
if ($post_id === 0 || $post === null || $post->post_status !== 'publish') {
    require_once '404.php';
    exit(0);
}
$tags = wp_get_post_terms($post_id, TAGS);

get_header();

?>
    <div class="content-box">
        <div class="project-container">
            <div class="centered-heading">
                <h1><?php echo $post->post_title; ?></h1>
                <?php if (count($tags) > 0): ?>
                    <div class="project-tag-container">
                        <?php foreach ($tags as $tag): ?>
                            <span class="project-tag">
                        <?php echo $tag->name; ?>
                    </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="project-content">
                <?php
                $thumb = get_the_post_thumbnail_url($post_id);
                if ($thumb !== false) {
                    echo '<img src="' . $thumb . '" alt="Project featured image" class="project-featured-image" class="project-featured-image"/>';
                }
                $content = apply_filters('the_content', $post->post_content);
                echo $content;
                ?>
            </div>
        </div>
    </div>
<?php
get_footer();

