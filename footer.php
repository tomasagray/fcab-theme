<?php

namespace fcab\theme;

define("TEMPLATE_DIR", get_template_directory());
define("ICON_DIR", '/img/social/');
define("THEME_URI", get_template_directory_uri());

?>
<!-- Cont. from header.php -->
</div>
</div>
</section>

<footer>
    <div id="fcab-footer-wrapper">
        <div id="fcab-footer-container">
            <a href="<?php echo get_site_url(); ?>">
                <img src="<?php echo THEME_URI; ?>/img/fcab_logo_small.png" id="footer-logo"
                     alt="FCAB | The Foundation for Charitable Activities in Bangladesh"/>
            </a>
            <div id="footer-nav-menu-container">
                <ul id="footer-nav-menu">
                    <?php
                    $bottom_menu = get_menu(BOTTOM_MENU);
                    if ($bottom_menu) {
                        foreach ($bottom_menu as $menu_item) {
                            echo '<li> <a href="'.$menu_item->url.'">';
                            echo $menu_item->title;
                            echo '</a></li>';
                        }
                    } else {
                        echo '<p>&nbsp;</p>';
                    }
                    ?>
                </ul>
            </div>
            <hr/>
            <div class="social-media-menu">
                <h4 id="social-heading">Keep up with our work</h4>
                <div id="social-button-container">
                    <?php
                    $social_menu = get_menu(SOCIAL_MENU);
                    if ($social_menu) {
                        $social_menu_html = get_social_menu_html($social_menu);
                        echo $social_menu_html;
                    } else {
                        handle_no_social_menu();
                    }
                    ?>
                </div>
            </div>
            <p id="copyright">&copy; FCAB <?php echo date('Y'); ?></p>
        </div>
    </div>
</footer>
<script>
    $(function () {
        initializeMobileMenu();
    });
</script>
</body>
</html>
