<?php

namespace fcab\theme;

use WP_Query;

const PROJECTS_DISPLAYED = 6;
const TAGS = 'fcab_project_tag';
const POST_TYPE = 'fcab_cpt_project';
const PROJECT_TAGS_MENU = 'tags-menu';


function get_query_url(array $param): string
{
    $url = $_SERVER['REQUEST_URI'];
    if (strpos($url, '?')) {
        if (strpos($url, 'project-tag=')) {
            $new_param = 'project-tag=' . $param['tag'];
            $url = preg_replace('/project-tag=[\w+=%-]+/', $new_param, $url);
        } else {
            $url .= '&project-tag=' . $param['tag'];
        }
    } else {
        $url .= '?project-tag=' . $param['tag'];
    }
    return $url;
}

/**
 * @param $current_tag
 * @return array
 */
function get_query_args($current_tag): array
{
    // for pagination
    $paged = get_query_var('page', 1);
    $q_args = [
        'post_type' => POST_TYPE,
        'post_status' => 'publish',
        'posts_per_page' => PROJECTS_DISPLAYED,
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => 'date'
    ];
    if ($current_tag !== null) {
        $q_args['tax_query'] = array([
            'taxonomy' => TAGS,
            'terms' => $current_tag->name,
            'field' => 'name'
        ]);
    }
    return $q_args;
}

/**
 * @param array $tags
 * @return mixed
 */
function get_current_tag()
{
    $tags = get_terms(['taxonomy' => TAGS]);
    $current_tag = null;
    if (isset($_GET['project-tag'])) {
        $tag_param = $_GET['project-tag'];
        foreach ($tags as $tag) {
            if ($tag->name === $tag_param) {
                $current_tag = $tag;
            }
        }
    }
    return $current_tag;
}

/**
 * @param $menu_items
 * @param null $current_term
 */
function print_tags_menu($menu_items, $current_term = null): void
{
    echo '<div class="project-tags-container">';
    echo '<form name="filter-tags" id="filter-tags" method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
    echo '<input type="hidden" name="project-tag" id="project-tag" />';
    foreach ($menu_items as $menu_item) {
        $filter_url = get_query_url(['tag' => $menu_item->title]);
            echo '<a class="project-sort-tag';
            if ($menu_item->title === $current_term->name) {
                echo ' current';
            }
            echo '" href="'. $filter_url .'">';
            echo $menu_item->title . '</a>';
    }
    echo '</form>';
    echo '</div>';
}

$tags_menu = get_menu(PROJECT_TAGS_MENU); //get_terms(['taxonomy' => TAGS]);
$current_tag = get_current_tag();
$q_args = get_query_args($current_tag);
$loop = new WP_Query($q_args);

get_header();
?>

    <div class="content-box">
        <h1 class="project-heading">Our Programs</h1>
        <?php
        print_tags_menu($tags_menu, $current_tag);

        if ($current_tag !== null) {
            echo '<div class="project-tag-data">';
            echo '<h2 class="project-tag-title">' . $current_tag->name . '</h2>';
            echo '<p class="project-tag-description">' . $current_tag->description . '</p>';
            echo '</div>';
        }
        ?>

        <h2>Current Projects</h2>
        <?php
        if ($loop->have_posts()): ?>
            <div class="project-card-container">
                <?php while ($loop->have_posts()): $loop->the_post();
                    $project_id = get_the_ID();
                    if (get_post_status($project_id) === 'publish'):
                        $thumb = get_the_post_thumbnail_url(get_the_ID());
                        echo '<div class="project-card">';
                        if ($thumb !== false) {
                            echo '<div class="project-card-image" style="background-image: url(\'' . $thumb . '\');">';
                            echo '</div>';
                        }
                        ?>
                        <div class="project-card-description">
                            <h3 class="project-title"><?php the_title(); ?></h3>
                            <p class="project-description">
                                <?php echo wp_strip_all_tags(wp_trim_excerpt('', $project_id), true); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="project-link">Learn more</a>
                        </div>
                        <?php
                        echo '</div>';
                    endif;
                endwhile; ?>
            </div>
            <div class="pagination-container">
                <div class="nav-previous alignleft"><?php $loop->previous_posts_link('Prev.'); ?></div>
                <div class="nav-next alignright"><?php $loop->next_posts_link('Next'); ?></div>
            </div>
        <?php else:
            echo '<p>There are currently no projects. Please check back soon.</p>';
        endif;
        ?>
    </div>
    <?php
get_footer();
