<?php

namespace fcab\theme;


require_once 'functions.php';

$theme_uri = get_template_directory_uri();
get_header();
?>
    <div class="content-box">
        <h1 class="centered-heading">Activities</h1>
        <div id="quick-jump-container" class="quick-jump-container">
            <?php print_quick_jump_menu(); ?>
        </div>
        <?php print_cpt_by_program(ACTIVITIES_CPT); ?>

        <img src="<?php echo $theme_uri; ?>/img/scroll-top-button.png"
             alt="Back to top" class="scroll-top-button"/>
    </div>
    <?php
get_footer();
