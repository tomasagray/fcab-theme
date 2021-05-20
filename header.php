<?php
/**
 * header.php - HTML head & page header
 */

namespace fcab\theme;


use const fcab\theme\MAIN_MENU;

$theme_uri = get_template_directory_uri();
$current_url =
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo $theme_uri; ?>/js/fcab.js"></script>
    <?php wp_head(); ?>
    <link href="<?php echo $theme_uri; ?>/fusion-styles.css" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/style.css" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/css/mobile.css" rel="stylesheet" media="screen and (max-width: 660px)">
    <script>
        $(function () {
            // Main menu handling
            // ====================================
            let handleMenuClick = function () {
                $menu = $('#nav-menu-main');
                $openButton = $('#mobile-menu-button');
                $closeButton = $('#mobile-menu-close-button');

                if ($menu.css('display') === 'none') {
                    openMobileMenu($menu, $openButton, $closeButton);
                } else {
                    closeMobileMenu($menu, $openButton, $closeButton);
                }
            };
            $('#mobile-menu-button').on('click', function () {
                handleMenuClick();
            });
            $('#mobile-menu-close-button').on('click', function () {
                handleMenuClick();
            });
        });
    </script>
</head>

<body>
<header>
    <div id="menu-wrapper">
        <div id="menu-container">
            <img src="<?php echo $theme_uri; ?>/img/menu_hamburger.png" alt="Open mobile menu" class="mobile-menu-button" id="mobile-menu-button"/>
            <img src="<?php echo $theme_uri; ?>/img/menu_close.png" alt="Close mobile menu" class="mobile-menu-button" id="mobile-menu-close-button"/>

            <a href="<?php echo get_site_url(); ?>"> <img src="<?php echo $theme_uri; ?>/img/fcab_logo_small.png"
                                                          alt="FCAB | The Foundation for Charitable Activities in Bangladesh"
                                                          id="header-logo"/> </a>
            <div id="menu-outer-container">
                <?php
                wp_nav_menu([
                    'theme_location' => MAIN_MENU,
                    'menu_class' => 'nav-main-menu',
                    'menu_id' => 'nav-main-menu',
                    'current-menu-item' => 'menu-item-current',
                    'container_class' => 'main-nav-menu-container',
                    'container_id' => 'nav-menu-main'
                ]);
                ?>
            </div>
        </div>
        <script>
            // add donation button styles
            $(function () {
                $('ul#nav-main-menu > li.menu-item').each(function () {
                    if ($(this).text().search('[\w\s\d]*[D|d]onat') !== -1) {
                        $(this).addClass('menu-item-donate');
                    }
                });
            });
        </script>
    </div>
</header>
<section>
<div id="content-wrapper">
    <div id="content-container">
