<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bj_template
 *
 * @author studio
 */
class bj_template {

    public function __construct() {

    }

    /**
     * Displays themes site logo
     * @param type $img_url default logo img url
     * @return string hmtl img of site name or set $img_url
     */
    public static function site_logo($img_url = null) {
        $logo = get_theme_mod('bjc_logo');
        if (!empty($logo)):
            return '<img src="' . $logo . '" alt="' . get_bloginfo('name') . '"  >';
        elseif (isset($img_url)):
            return '<img src="' . $img_url . '" alt="' . get_bloginfo('name') . '"  >';
        else :
            return get_bloginfo('name');
        endif;
    }

    public static function footer_info() {
        ?>
        <p class="footer-slug">
            <?php echo get_theme_mod('bjc_footer_slug'); ?>
        </p>
        <p class="copyrignt-info">
            <?php echo get_theme_mod('bjc_copyright_slug'); ?>
        </p>

        <!-- ###### -->
        <?php do_action('bj_credits'); ?>
        <?php
        $bjc_copyinfo = get_theme_mod('bjc_enable_copyinfo');
        if (empty($bjc_copyinfo)):
            ?>
            <a href="http://wordpress.org/" title="<?php esc_attr_e('A Semantic Personal Publishing Platform', 'bj'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?></a>
            <span class="sep"> | </span>
            <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>
        <?php endif; ?>
        <?php
    }

}
