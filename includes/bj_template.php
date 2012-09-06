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
        <?php do_action('bj_credits'); ?>
        <p class="footer-slug">
            <?php echo esc_textarea($bjc_fslug = get_theme_mod('bjc_footer_slug')); ?>
        </p>
        <p class="copyrignt-info">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>.
            <?php echo esc_textarea($bjc_cslug = get_theme_mod('bjc_copyright_slug', __('All rights reserved', 'bj'))); ?>

        </p>

        </p>

        <!-- ###### -->

        <?php
        $bjc_copyinfo = get_theme_mod('bjc_enable_copyinfo');
        if (empty($bjc_copyinfo)):
            ?>
            <a href="http://wordpress.org/" title="<?php esc_attr_e('A Semantic Personal Publishing Platform', 'bj'); ?>" rel="generator"><?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?></a>
            <span class="sep"> | </span>
            <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>
        <?php else : ?>
            <!--     <?php printf(__('Proudly powered by %s', 'bj'), 'WordPress'); ?>      -->
            <!--     <?php printf(__('Theme: %1$s by %2$s.', 'bj'), 'bj', '<a href="http://shawnsandy.com/" rel="designer">ShawnSandy.com</a>'); ?>       -->
        <?php endif; ?>
        <?php
    }

    public static function contact_org() {
        ?>
        <address>
            <strong><?php echo get_theme_mod('bjc_org_name'); ?></strong><br>
            <?php echo get_theme_mod('bjc_contact_address') ?>
            <br>
            <?php echo get_theme_mod('bjc_contact_city') . '  ' . get_theme_mod('bjc_contact_zip') . ' ' . get_theme_mod('bjc_contact_zip'); ?>
            <br>
            <abbr title="Phone">P:</abbr> <?php echo get_theme_mod('bjc_contact_tel'); ?>
        </address>
        <?php
    }

    public static function contact_author() {
        global $post;
        $author = $post->post_author;
        ?>
        <address>
            <strong><?php echo get_the_author_meta('first_name', $author) . ' ' . get_the_author_meta('last_name', $author); ?></strong><br>
            <a href="mailto:#"><?php echo antispambot(get_the_author_meta('user_email', $author)); ?></a>
        </address>
        <?php
    }

    public static function flickr_badge($flickrID = null, $postcount = 9, $display = 'latest', $type = 'user') {
        if(isset($flickrID)):
        ?>
        <div id="bj-flickr-badge">
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
        </div>
        <?php
        else :
            echo "Flickr ID required";
        endif;

    }

}
