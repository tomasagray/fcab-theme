<?php

namespace fcab\theme;


global $query_string;
$search_query = array();
if (strlen($query_string) > 0) {
    $query_args = explode("&", $query_string);
    foreach ($query_args as $key => $value) {
        $query_split = explode("=", $value);
        $search_query[$query_split[0]] = urldecode($query_split[1]);
    }
}

get_header();
?>

<h1>Search results</h1>

<?php var_dump($search_query); ?>

<?php
global $wp_query;
$total_results = $wp_query->found_posts;
?>


<div id="search-result-container">

</div>

<p id="search-result-total">Total results: <?php echo $total_results; ?></p>

<div class="nav-previous alignleft"><?php previous_posts_link( 'Older posts' ); ?></div>
<div class="nav-next alignright"><?php next_posts_link( 'Newer posts' ); ?></div>

<?php get_footer(); ?>
