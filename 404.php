<?php

namespace fcab\theme;

/**
 * @return string
 */
function get_current_url(): string
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443)
        ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

$url = get_current_url();

get_header();
?>
    <style>
        p { margin: 3rem auto; }
        label { display: none; }
    </style>

    <div class="content-box">
        <h1>Not found!</h1>

        <p>We're sorry, but the page you requested does not exist. Please check the URL, and try again.<br/>
            Alternatively, use the menus at the top and bottom of the page to navigate.</p>
        <p>Requested URL: <b><?php echo $url; ?></b></p>

        <h3>Or, try searching our site:</h3>
        <?php get_search_form(); ?>
    </div>
    <?php
get_footer();
