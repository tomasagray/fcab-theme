<?php

namespace fcab\theme;

// Impact metric shortcode
function impact_metric($attrs = array(), $content = null)
{
    // set up default parameters
    extract(shortcode_atts(array(
        'data' => ' '
    ), $attrs), EXTR_OVERWRITE);

    return '<div class="impact-metric-container">'
                . '<h3 class="impact-metric-data">' . $data . '</h3>'
                . '<p class="impact-metric-description">' . $content . '</p>'
            . '</div>';
}

function impact_metric_row($attrs = array(), $content = null)
{
    return '<div class="impact-metric-row">'.do_shortcode($content).'</div>';
}

add_shortcode('impact-metric-row', 'fcab\theme\impact_metric_row');
add_shortcode('impact-metric', 'fcab\theme\impact_metric');
