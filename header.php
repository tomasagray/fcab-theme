<?php
/**
 * header.php - HTML head & page header
 */

namespace fcab\theme;


$theme_uri = get_template_directory_uri();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo $theme_uri; ?>/js/vendor/slick/slick.min.js"></script>
    <script src="<?php echo $theme_uri; ?>/js/fcab.js"></script>
    <script src="<?php echo $theme_uri; ?>/js/mobile-menu.js"></script>
    <script src="<?php echo $theme_uri; ?>/js/carousel.js"></script>
    <?php wp_head(); ?>
    <link href="<?php echo $theme_uri; ?>/css/fusion-styles.css" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/css/fusion-overrides.css" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/style.css" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/css/mobile.css" rel="stylesheet" media="screen and (max-width: 599px)">
    <link href="<?php echo $theme_uri; ?>/css/tablet-portrait.css" rel="stylesheet"
          media="screen and (min-width: 600px) and (max-width: 899px)">
    <link href="<?php echo $theme_uri; ?>/css/tablet-landscape.css" rel="stylesheet"
          media="screen and (min-width: 900px) and (max-width: 1199px)">
    <link href="<?php echo $theme_uri; ?>/css/laptop.css" rel="stylesheet"
          media="screen and (min-width: 1200px) and (max-width: 1799px)">
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_uri; ?>/js/vendor/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_uri; ?>/js/vendor/slick/slick-theme.css"/>
</head>

<body>
<header>
    <div id="menu-wrapper">
        <div id="menu-container">
            <div id="mobile-menu-button-container">
                <img src="<?php echo $theme_uri; ?>/img/menu_hamburger.png" alt="Open mobile menu"
                     class="mobile-menu-button" id="mobile-menu-button"/> <img
                        src="<?php echo $theme_uri; ?>/img/menu_close.png" alt="Close mobile menu"
                        class="mobile-menu-button" id="mobile-menu-close-button"/>
            </div>

            <a href="<?php echo get_site_url(); ?>"> <img src="<?php echo $theme_uri; ?>/img/fcab_logo_small.png"
                                                          alt="FCAB | The Foundation for Charitable Activities in Bangladesh"
                                                          id="header-logo"/> <img
                        src="<?php echo $theme_uri; ?>/img/fcab_logo_mobile.png"
                        alt="FCAB | The Foundation for Charitable Activities in Bangladesh" id="header-logo-mobile"/>
            </a>
            <div id="menu-outer-container">
                <div id="nav-menu-main" class="main-nav-menu-container">
                    <?php
                    $menu_array = get_menu(MAIN_MENU);
                    $menu = get_menu_object($menu_array, 'nav-main-menu');
                    echo $menu->toHtml('nav-main-menu');
                    ?>
                </div>
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
