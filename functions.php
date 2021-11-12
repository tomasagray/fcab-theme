<?php

namespace fcab\theme;

use WP_Query;
use WP_Term;

require_once 'custom-shortcodes.php';
require_once 'Menu.php';
require_once 'MenuItem.php';

const MAIN_MENU = 'main-menu';
const BOTTOM_MENU = 'bottom-menu';
const SOCIAL_MENU = 'social-menu';
const PROJECT_TAGS_MENU = 'tags-menu';
const PAGE_URL_PATTERN = '/(\/page\/)(\d)+[\/]?/';
const PROGRAMS_CPT = 'fcab_cpt_program';
const PROGRAM_TAG = 'fcab_program_tag';
const PROJECTS_CPT = 'fcab_cpt_project';
const ACTIVITIES_CPT = 'fcab_cpt_activity';
const CARDS_DISPLAYED = 6;


function get_menu($location)
{
    if (($locations = get_nav_menu_locations()) && isset($locations[$location])) {
        $menu = wp_get_nav_menu_object($locations[$location]);
        return wp_get_nav_menu_items($menu->term_id);
    }
    return false;
}

/**
 * Translate WP menu array to complex object
 * @param $wp_menu_items array WordPress-generated menu array
 */
function get_menu_object(array $wp_menu_items, string $menu_title): Menu
{
    $menu = new Menu(null, $menu_title);
    foreach ($wp_menu_items as $menu_item) {
        $item = new MenuItem($menu_item->ID, $menu_item->url, $menu_item->title, null);
        $parent_id = (int)$menu_item->menu_item_parent;
        if ($parent_id !== 0) {
            $menu->addSubmenuItem($parent_id, $item);
        } else {
            $menu->addItem($item);
        }
    }
    return $menu;
}

function get_social_menu_html(array $social_menu): string
{
    $icons = read_social_icons();

    $html = '<ul class="social-button-menu">';
    foreach ($social_menu as $menu) {
        $url = parse_url($menu->url);
        $host = strtolower(substr($url['host'], 0, strpos($url['host'], '.')));
        $icon_name = $host . '.svg';
        $html .= '<li> <a href="' . $menu->url . '" target="_blank" class="social-icon">';
        if (in_array($icon_name, $icons, true)) {
            $icon = THEME_URI . '/' . ICON_DIR . $icon_name;
            $html .= '<img alt="' . $menu->title . '" src="' . $icon . '"/>';
        } else {
            $html .= '<span class="social-button-letter">'
                . strtoupper($host[0])
                . '</span>';
        }
        $html .= '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

function read_social_icons(): array
{
    $icons = [];
    if ($dir = opendir(TEMPLATE_DIR . ICON_DIR)) {
        while (($icon = readdir($dir)) !== false) {
            if ($icon !== '.' && $icon !== '..') {
                $icons[] = $icon;
            }
        }
        closedir($dir);
    }
    return $icons;
}

function handle_no_social_menu()
{
    echo '<p class="warning">There is no social networking menu defined.</p>';
}

function register_main_menu()
{
    register_nav_menu(MAIN_MENU, __('Main Menu'));
}

function register_bottom_menu()
{
    register_nav_menu(BOTTOM_MENU, __('Footer Menu'));
}

function register_social_menu()
{
    register_nav_menu(SOCIAL_MENU, __('Social Networking Menu'));
}

function register_project_tags_menu()
{
    register_nav_menu(PROJECT_TAGS_MENU, __('Project Tags Menu'));
}

/**
 * @param $post_type string Custom Post Type identifier
 * @param $current_tag ?WP_Term Program Tag
 * @return array
 */
function get_cpt_query(string $post_type, WP_Term $current_tag = null): array
{
    $page_num = get_page_num();
    $q_args = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => CARDS_DISPLAYED,
        'paged' => $page_num,
        'order' => 'DESC',
        'orderby' => 'date'
    ];
    if ($current_tag !== null) {
        $q_args['tax_query'] = array([
            'taxonomy' => PROGRAM_TAG,
            'terms' => $current_tag->name,
            'field' => 'name'
        ]);
    }
    return $q_args;
}

/**
 * @param WP_Query $loop
 */
function print_project_cards(WP_Query $loop): void
{
    while ($loop->have_posts()): $loop->the_post();
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
                    <?php
                    $excerpt = wp_strip_all_tags(wp_trim_excerpt('', $project_id), true);
                    // remove empty spaces
                    $excerpt = str_replace(array("\xc2\xa0", "&nbsp;"), '', $excerpt);
                    echo trim($excerpt);
                    ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="project-link">Learn more</a>
            </div>
            <?php
            echo '</div>';
        endif;
    endwhile;
}

/**
 * @return string
 */
function get_query_string(): ?string
{
    if (in_array('REDIRECT_QUERY_STRING', $_SERVER, true)) {
        $query = $_SERVER['REDIRECT_QUERY_STRING'];
        if ($query !== null) {
            $query = '?' . $query;
        }
        return $query;
    }
    return null;
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

// Hooks
add_action('init', 'fcab\theme\register_main_menu');
add_action('init', 'fcab\theme\register_bottom_menu');
add_action('init', 'fcab\theme\register_social_menu');
add_action('init', 'fcab\theme\register_project_tags_menu');
// enable features
add_theme_support('post-thumbnails');
add_post_type_support('page', 'excerpt');
