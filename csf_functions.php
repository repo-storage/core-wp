<?php

/**
 * @package WordPress
 * @subpackage BaseJump5
 * @author shawnsandy
 */


/**
 * INSTANIATE core classes
 */
$cwp_core = CWP_CORE::factory();
$cwp_classes = CWP_CLASSES::factory();

/**
 * *****************************************************************************
 * Get theme setttings *********************************************************
 * *****************************************************************************
 */




/**
 *
 * @param type $option theme options value
 */
function cwp_theme_settings($option = '') {
    $option = (cwp::theme_options($option) ? cwp::theme_options($option) : 1);
    return $option;
}

/**
 *
 * @param type $option theme options value
 */
function cwp_themeadmin($option = 'themeadmin') {
    $option = (cwp::theme_options($option) ? cwp::theme_options($option) : 1);
    return $option;
}

$the_theme_admin = cwp_themeadmin('themeadmin');



// Disable WordPress version reporting as a basic protection against attacks
function remove_generators() {
    return '';
}

//add_filter('the_generator', 'remove_generators');

/*
 * add layout tpl
 */
add_filter('template_include', array('cwp_layout', 'tpl_include'));


/**
 * adds all post functions
 */
add_theme_support('post-formats', array('aside', 'gallery', 'video', 'link', 'image', 'quote', 'status', 'chat'));




/**
 * *****************************Theme setup************************************
 */
add_action('after_setup_theme', 'cwp_theme_setup');

function cwp_theme_setup() {

    add_theme_support('menus');
    register_nav_menu('primary', __('Primary', 'basejump'));
    register_nav_menu('browse', __('Browse', 'basejump'));
    register_nav_menu('category', __('Categories', 'basejump'));
    register_nav_menu('about', __('About', 'basejump'));

    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on _s, use a find and replace
     * to change '_s' to the name of your theme in all the template files
     */
    load_theme_textdomain('basejump', get_template_directory() . '/languages');

    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";
    if (is_readable($locale_file))
        require_once( $locale_file );

    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support('automatic-feed-links');

    core_functions::favicon();
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_image_size('icon-60', 60, 60, true);
    add_image_size('icon-100', 100, 100, true);
    add_image_size('icon-40', 40, 40, true);
}

/*
 * register scripts*************************************************************
 */

add_action('wp_enqueue_scripts', 'jump_scripts');

function jump_scripts() {
    /**
     * setup some script variables
     */
    $css_path = get_template_directory_uri() . '/library/css';

    /**
     * bootstrap scripts
     */

    wp_register_script('bootstrap-alert', cwp::locate_in_library('bootstrap-alert.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-buttons', cwp::locate_in_library('bootstrap-button.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-dropdown', cwp::locate_in_library('bootstrap-dropdown.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-modal', cwp::locate_in_library('bootstrap-modal.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-popover', cwp::locate_in_library('bootstrap-popover.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-scrollspy', cwp::locate_in_library('bootstrap-scrollspy.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-tabs', cwp::locate_in_library('bootstrap-tab.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-twipsy', cwp::locate_in_library('bootstrap-twispy.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-transition', cwp::locate_in_library('bootstrap-transition.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-collapse', cwp::locate_in_library('bootstrap-collapse.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-typeahead', cwp::locate_in_library('bootstrap-typeahead.js', 'bootstrap/js'), array('jquery'), '', true);
    wp_register_script('bootstrap-tooltip', cwp::locate_in_library('bootstrap-tooltip.js', 'bootstrap/js'), array('jquery'), '', true);






    /**
     * Main theme js scripts
     */
    if (!is_admin()) {
        //cwp::jquery();
        //wp_enqueue_script('jquery');
        wp_enqueue_script('modernizer', get_template_directory_uri() . '/library/js/modernizr.custom.48627.js', array('jquery'), false, true);
        wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/library/js/scripts.js', array(), false, true);
    }
}




/*
 * footer widgets
 */
cwp::add_widget('Top Sidebar', 'top-sidebar', 'Top sidebar widget');
cwp::add_widget('info 1', 'info-1', 'Display widgets in the first footer box');
cwp::add_widget('info 2', 'info-2', 'Display widgets in the second footer box');
cwp::add_widget('info 3', 'info-3', 'Display widgets in the third footer box');
cwp::add_widget('info 4', 'info-4', 'Display widgets in the fourth footer box');
cwp::add_widget('info 5', 'info-5', 'Display widgets in the fifth footer box');
cwp::add_widget('Widget Page', 'widget-page', 'Display widgets on the widget-page tpl');
cwp::register_sidebar('404 Page', '404-page', 'Display widgets on the 404-page tpl');





/**
 * footer
 */
add_action('wp_footer', 'theme_footer');

function theme_footer() {

}

/*
 * add thumbnails to editior list
 */
core_admin::post_list_thumbs();


/*
 * add columns
 */
core_admin::column_id();


/*
 * add post style to TinyMCS editor
 */
//core_admin::editor_style();



/**
 * stop self pingbacks
 */
core_admin::end_self_ping();


/**
 * Contact info
 */
//global $user ;
//if(current_user_can('Administrator'))
cwp_social::contact_info();



/**
 * *****************************************************************************
 * custom hooks
 * *****************************************************************************
 */
function cwp_mobile_head() {
    do_action('cwp_mobile_head');
}

function cwp_mobile_footer() {
    do_action('cwp_mobile_footer');
}


    /**
     * *********************************Figure - Image ****************************
     * http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
     */

    function cwp_img_unautop($fig) {
        $fig = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<div class="figure">$1</div>', $fig);
        return $fig;
    }

    add_filter('the_content', 'cwp_img_unautop', 30);


    /**
     * Sets default permalink
     */
    /**
     * Google analytics
     */
    if (!class_exists('GA_Admin') AND !class_exists('GA_Filter'))
        add_action('wp_head', 'cwp_theme_analytics');

    function cwp_theme_analytics() {


        if (cwp::theme_options('gakey')):
            //ob_start();
            ?>
            <script type="text/javascript">//<![CDATA[
                // Basic Analytics
                // Please Install - Google Analytics for WordPress by Yoast v4.2.2 | http://yoast.com/wordpress/google-analytics/
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount','<?php echo cwp::theme_options('gakey'); ?>']);
                _gaq.push(['_trackPageview'],['_trackPageLoadTime']);
                (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
                //]]>
            </script>

            <?php
        endif;
    }

    /**
     * *****************************************************************************
     * THEME (DE)ACTIVATION
     * Theme activation hook: 'after_switch_theme'
     * Theme de-activation hook: 'switch_theme'
     */

    /**
     * theme activation functions
     */
    function cwp_after_switch_theme() {

    }

    /**
     * Theme decativation functions
     */
    function cwp_switch_theme() {
        //update_option('cwp_last_theme', "theme switched reactivated");
        if (!cwp::theme_options('saveoptions') AND cwp::theme_options('saveoptions') == 0)
            delete_option('cwp_theme_options');
    }

    add_action('switch_theme', 'cwp_switch_theme');
    add_action('after_switch_theme', 'cwp_after_switch_theme');

  /**
   * Theme options
   * Instantiate and load theme options
   */
    $cpt_options = cwp_theme::options();





if ( ! function_exists( '_bj_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since basejump 1.0
 */
function _bj_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'basejump' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'basejump' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">

					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'basejump' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'basejump' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'basejump' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'basejump' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for _s_comment()


function csf_default_menus() {
    /**
     * This theme uses wp_nav_menu() in one location.
     * used in theme functions
     */
    // This theme styles the visual editor with editor-style.css to match the theme style.


    add_theme_support('menus');
    register_nav_menu('primary', __('Primary', 'basejump'));
    register_nav_menu('browse', __('Browse', 'basejump'));
    register_nav_menu('category', __('Categories', 'basejump'));
    register_nav_menu('about', __('About', 'basejump'));

}