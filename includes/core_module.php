<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of core_modules
 *
 * @author Studio365
 */
class core_module {

    function __construct() {

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
    public static function tpl($template='index', $module='default',  $data=array(), $require_once=false) {
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
     *
     * @param type $module
     * @param type $name
     */
    public static function get_module_part($module, $name = null) {
        do_action("get_template_part_{$module}", $module, $name);

        $templates = array();
        if (isset($name))
            $templates[] = "{$name}.php";
        //$templates[] = "{$slug}.php";
        $templates[] = "{$module}.php";
        $templates[] = "index.php";
        return $tpl = self::locate_module($templates,$module, true, false);
    }


}

?>
