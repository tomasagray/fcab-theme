<?php


namespace fcab\theme;


require_once 'functions.php';

get_header();
?>
    <div class="content-box">
        <h1 class="centered-heading">Activities</h1>
        <?php print_cpt_by_program(ACTIVITIES_CPT); ?>
    </div>
    <?php
get_footer();
