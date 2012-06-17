<?php

/**
 * Load your modules into your themes
 *
 * @author Studio365
 */

class core_mods {
    //put your code here

    public function __construct() {

    }

     /**
     * Load independant themes templates (modules), push custom data array, load from child/parents thene or plugin dir
     * Based on the wp template system
     * @global type $posts
     * @global type $post
     * @global type $wp_did_header
     * @global type $wp_did_template_redirect
     * @global type $wp_query
     * @global type $wp_rewrite
     * @global type $wpdb
     * @global type $wp_version
     * @global type $wp
     * @global type $id
     * @global type $comment
     * @global type $user_ID
     * @param string $template
     * @param array $data
     * @param bool $require_once
     * @param string $module
     */
    public static function modules($template='index', $module='default',  $data=array(), $require_once=false) {
        global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if (is_array($data) AND !empty($data))
            extract($data);

        $template = $template . '.php';

        //$file = PLUGINDIR . '/core-wp/modules/' . $module . '/tpl/' . $template ;
         $file = CM_PATH . '/' . $module . '/tpl/' . $template;

        if (file_exists(STYLESHEETPATH . '/tpl/' . $module .'/' . $template)) {
            $file = STYLESHEETPATH . '/tpl/'  . $module .'/' . $template;
        } elseif (file_exists(STYLESHEETPATH . '/' . $module .'/' . $template)) {
            $file = STYLESHEETPATH . '/' . $module .'/' . $template;
        } elseif (file_exists(TEMPLATEPATH .  '/tpl/' . $module .'/' . $template)) {
            $file = TEMPLATEPATH . '/tpl/' . $module .'/' . $template;
        } elseif (file_exists(TEMPLATEPATH . '/' . $module .'/' . $template)) {
            $file = TEMPLATEPATH . '/' . $module .'/' . $template;
        }

        if (file_exists($file))
            if ($require_once):
                require_once $file;
            else:
                require $file;
        endif;
        else
            echo "MODULE NOT FOUND";
    }

     /**
     * Locates a file path e.g. home/www/images/video/stylesheets
     * Searches core-wp/modules plugin directory in plugin,
     * - core-WP in the stylesheet / template directory
     * - modules in the stylesheet / template directory
     * - stylesheet / template directory
     * @param string $file filename
     * @param string $dir path to file - dirname/ (w/trailing slash)
     * @return string
     */
    public static function locate($file, $dir=NULL) {
        $located = false;
        $fname = $dir . $file;
        $file = CM_PATH . '/' . $fname;
        if (file_exists(get_stylesheet_directory() . '/core-wp/modules/' . $fname)):
            $file = get_stylesheet_directory() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/core-wp/modules/' . $fname)):
            $file = get_template_directory() . '/core-wp/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() . '/modules/' . $fname)):
            $file = get_stylesheet_directory() . '/modules/' . $fname;
        elseif (file_exists(get_template_directory() . '/modules/' . $fname)):
            $file = get_template_directory() . '/modules/' . $fname;
        elseif (file_exists(get_stylesheet_directory() .'/' . $fname)):
            $file = get_stylesheet_directory() .'/' . $fname;
        elseif (file_exists(get_template_directory().'/' . $fname)):
            $file = get_template_directory().'/' . $fname;
        endif;
        if (file_exists($file)):
            return $file;
        else :
            return false;
        endif;
    }

}

?>
