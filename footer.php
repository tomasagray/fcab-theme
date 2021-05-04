<?php

namespace fcab\theme;


// get extended (full) nav menu
$menus = wp_get_nav_menus();


$theme_uri = get_template_directory_uri();
?>
<div id="fcab-footer-container">
    <img src="<?php echo $theme_uri; ?>/img/fcab_logo_small.png" id="footer-logo"
         alt="FCAB | The Foundation for Charitable Activities in Bangladesh"/>
    <div id="footer-nav-menu">
        <?php var_dump($menus); ?>
    </div>
    <hr/>
    <h4 id="social-heading">Keep up with our work</h4>
    <div id="social-button-container">

    </div>
    <p id="copyright">&copy; FCAB <?php echo date('Y'); ?></p>
</div>
</body>
</html>
