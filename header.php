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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
    <link href="<?php echo $theme_uri; ?>/style.css" rel="stylesheet">
</head>

<body>

<div id="menu-wrapper">
    <div id="menu-container">
        <a href="<?php echo get_site_url(); ?>">
            <img src="<?php echo $theme_uri; ?>/img/fcab_logo_small.png" alt="FCAB | The Foundation for Charitable Activities in Bangladesh" id="header-logo"/>
        </a>
        <?php wp_nav_menu([
            'menu_class' => 'nav-menu',
            'menu_id' => 'nav-menu-main'
        ]); ?>
    </div>
</div>
