<?php

namespace fcab\theme;

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443)
    ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

get_header();
?>
    <style>
        p { margin: 3rem auto; }
        label { display: none; }
    </style>

    <h1>Not found!</h1>

    <p>We're sorry, but the page you requested does not exist. Please check the URL, and try again.<br/>
        Alternatively, use the menus at the top and bottom of the page to navigate.</p>
    <p>Requested URL: <b><?php echo $url; ?></b></p>

    <h3>Or, try searching our site:</h3>
    <?php get_search_form(); ?>

    <?php
get_footer();
