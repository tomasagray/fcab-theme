<?php

namespace fcab\theme;


// Impact metric
// =======================================================
function impact_metric($attrs = array(), $content = null): string
{
    // set up default parameters
    $shortcode_attrs = shortcode_atts(array(
        'data' => ' '
    ), $attrs);
    extract($shortcode_attrs, EXTR_OVERWRITE);

    $header_size = 3;
    if (strlen($data) > 4) {
        $header_size = 4;
    }
    if (strlen($data) > 9) {
        $header_size = 5;
    }

    return '<div class="impact-metric-container">'
        . '<h' . $header_size . ' class="impact-metric-data">' . $data . '</h' . $header_size . '>'
        . '<p class="impact-metric-description">' . do_shortcode($content) . '</p>'
        . '</div>';
}

function impact_metric_row($attrs = array(), $content = null): string
{
    return '<div class="impact-metric-row">' . do_shortcode($content) . '</div>';
}


// Volunteer quote
// ==============================================================
function volunteer_quote($attrs = array(), $content = null)
{
    $volunteer_id = url_to_postid($content);
    get_post($volunteer_id);
    ?>
    <div class="volunteer-quote-container">
        <?php echo get_the_post_thumbnail($volunteer_id, 'medium', array('class' => 'volunteer-portrait')); ?>
        <div class="volunteer-quote-data">
            <p class="volunteer-quote-text">
                <?php echo '"' . get_the_excerpt($volunteer_id) . '"'; ?>
            </p>
            <p>- <?php echo get_the_title($volunteer_id); ?></p>
        </div>
    </div>
    <?php
}

function volunteer_quotes_column($attrs = array(), $content = null)
{
    ?>
    <div class="volunteer-quotes-container">
        <?php echo do_shortcode($content); ?>
    </div>
    <?php
}


add_shortcode('impact-metric', 'fcab\theme\impact_metric');
add_shortcode('impact-metric-row', 'fcab\theme\impact_metric_row');
add_shortcode('volunteer-quote', 'fcab\theme\volunteer_quote');
add_shortcode('volunteer-quotes-column', 'fcab\theme\volunteer_quotes_column');
