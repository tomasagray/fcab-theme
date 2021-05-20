<?php

namespace fcab\theme;

const MAIN_MENU = 'main-menu';
const BOTTOM_MENU = 'bottom-menu';
const SOCIAL_MENU = 'social-menu';


function get_menu($location)
{
    if (($locations = get_nav_menu_locations()) && isset($locations[$location])) {
        $social_menu = wp_get_nav_menu_object($locations[$location]);
        return wp_get_nav_menu_items($social_menu->term_id);
    }
    return false;
}

function get_main_menu_html(array $main_menu): string
{

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
                . strtoupper(substr($host, 0, 1))
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

add_action('init', 'fcab\theme\register_main_menu');
add_action('init', 'fcab\theme\register_bottom_menu');
add_action('init', 'fcab\theme\register_social_menu');
