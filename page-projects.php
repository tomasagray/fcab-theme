<?php

namespace fcab\theme;

use WP_Query;

const PROJECTS_DISPLAYED = 6;
const TAGS = 'fcab_project_tag';
const PROJECTS_CPT = 'fcab_cpt_project';
const PROJECT_TAGS_MENU = 'tags-menu';
const PAGE_URL_PATTERN = '/(\/page\/)(\d)+[\/]?/';


function get_query_url(array $param = null): string
{
    $url = $_SERVER['REQUEST_URI'];
    if ($param !== null) {
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
    }
    return $url;
}

function get_page_num(): int
{
    $url = get_query_url();
    $matches = [];
    // examine URL for page number
    preg_match(PAGE_URL_PATTERN, $url, $matches);
    if (count($matches) >= 3 && $matches[2] !== null) {
        return (int)$matches[2];
    }
    return 1; // default
}

/**
 * @param $current_tag
 * @return array
 */
function get_query_args($current_tag): array
{
    // for pagination
    $page_num = get_page_num();
    $q_args = [
        'post_type' => PROJECTS_CPT,
        'post_status' => 'publish',
        'posts_per_page' => PROJECTS_DISPLAYED,
        'paged' => $page_num,
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
        // remove page numbers
        $filter_url = preg_replace(PAGE_URL_PATTERN, '', $filter_url);
        echo '<a class="project-sort-tag';
        if ($current_term !== null && $menu_item->title === $current_term->name) {
            echo ' current';
        }
        echo '" href="' . $filter_url . '">';
        echo $menu_item->title . '</a>';
    }
    echo '</form>';
    echo '</div>';
}

function get_prev_link($loop): ?string
{
    $page = $loop->query_vars['paged'];
    if ($page > 1) {
        $url = $_SERVER['REDIRECT_URL'];
        $page_url = '/page/' . ($page - 1);
        $query = get_query_string();
        if (preg_match(PAGE_URL_PATTERN, $url)) {
            return preg_replace(PAGE_URL_PATTERN, $page_url, $url) . $query;
        }
        return $url . $page_url . $query;
    }
    return null;
}

function get_next_link($loop): ?string
{
    $page = $loop->query_vars['paged'];
    if ($page < $loop->max_num_pages) {
        $url = $_SERVER["REDIRECT_URL"];
        $query = get_query_string();
        $page_url = '/page/' . ($page + 1);
        if (preg_match(PAGE_URL_PATTERN, $url)) {
            return preg_replace(PAGE_URL_PATTERN, $page_url, $url) . $query;
        }
        return $url . $page_url . $query;
    }
    return null;
}

function get_page_link_html($url, $text): string
{
    if ($url === null || $text === null) {
        return "";
    }
    return '<a href="' . $url . '" class="small-link-button">' . $text . '</a>';
}

/**
 * @return string
 */
function get_query_string(): ?string
{
    $query = $_SERVER['REDIRECT_QUERY_STRING'];
    if ($query !== null) {
        $query = '?' . $query;
    }
    return $query;
}

$tags_menu = get_menu(PROJECT_TAGS_MENU);
$current_tag = get_current_tag();
$q_args = get_query_args($current_tag);
$loop = new WP_Query($q_args);

get_header();
?>

    <div class="content-box">
        <h1 class="project-heading">Projects</h1>
        <?php
        print_tags_menu($tags_menu, $current_tag);
        if ($current_tag !== null) {
            echo '<div class="project-tag-data">';
            echo '<h2 class="project-tag-title">' . $current_tag->name . '</h2>';
            echo '<p class="project-tag-description">' . $current_tag->description . '</p>';
            echo '</div>';
        }
        ?>

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
                endwhile;
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
            echo '<p>There are currently no projects. Please check back soon.</p>';
        endif;
        ?>
    </div>
    <?php
get_footer();
