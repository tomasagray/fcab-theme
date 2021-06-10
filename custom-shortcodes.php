<?php

namespace fcab\theme;

// Impact metric
function impact_metric($attrs = array(), $content = null)
{
    // set up default parameters
    extract(shortcode_atts(array(
        'data' => ' '
    ), $attrs), EXTR_OVERWRITE);

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

function impact_metric_row($attrs = array(), $content = null)
{
    return '<div class="impact-metric-row">' . do_shortcode($content) . '</div>';
}

add_shortcode('impact-metric-row', 'fcab\theme\impact_metric_row');
add_shortcode('impact-metric', 'fcab\theme\impact_metric');

// Volunteer quote
function volunteer_quote($attrs = array(), $content = null)
{
    extract(shortcode_atts(array(
        'data' => ' '
    ), $attrs), EXTR_OVERWRITE);

    
}
