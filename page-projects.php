<?php

namespace fcab\theme;


require_once 'functions.php';

get_header();
?>
    <div class="content-box">
        <h1 class="centered-heading">Projects</h1>
        <div id="quick-jump-container" class="quick-jump-container">
            <?php print_quick_jump_menu(); ?>
        </div>
        <?php print_cpt_by_program(PROJECTS_CPT); ?>
    </div>
    <?php
get_footer();
