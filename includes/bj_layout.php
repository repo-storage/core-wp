<?php

/**
 * @package WordPress
 * @subpackage Toolbox
 */

class bj_layout {

    //put your code here

    public function __construct() {

    }

    private static $main_tpl;

    private static $base_tpl;

    public static function base_tpl() {
        return self::$base_tpl;
    }

    /**
     *
     * @param type $name
     * @param type $slug
     */
    public static function use_tpl($name = NULL,$slug=null) {
        $use = "index";
        if (isset($name))
            $use = "tpl-{$name}";
        self::tpl_part($slug, $use);
    }

    /**
     * Main Tpl Loads layout code (loop)
     * @param boolean $load use default wordpress loadtemplate
     * @param string $slug - location of directory in theme folder
     */
    public static function main_tpl($slug=null,$load=false) {
        $tpl = self::$main_tpl;
        if(isset($slug)) $tpl = $slug.'-'.self::$main_tpl;
        if($load):
            load_template($tpl);
        return;
        endif;
        include $tpl;
    }

    public static function tpl_include($template) {

        //checks to see if mobile theme is available
        $mobile_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile.php') or file_exists(get_stylesheet_directory() . '/tbs-mobile.php')):
        $mobile_themes = true;
        endif;

        if (cwp::theme_settings('offline') == 1 and !current_user_can('manage_options'))
           self::$main_tpl = get_stylesheet_directory() . '/offline.php';
        else
            self::$main_tpl = $template;

        self::$base_tpl = substr(basename(self::$main_tpl), 0, -4);

        if ('index' == self::$base_tpl)
            self::$base_tpl = false;


        /**
         *  check to seee if a mobile templaate exists in stylesheet dir and load
         *  to disable mobile themes create a child theme without a mobile template
         */

        if ($mobile_themes AND mod_mobile::detect()->isPhone()) {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/mobile/tbs-mobile.php', 'tpl/mobile/mobile.php',);
            if (self::$base_tpl) {
                //twitter bootstrap themes
                array_unshift($templates, sprintf('tpl/mobile/tpl-tbs-mobile-%s.php', self::$base_tpl));
                //foundation themes - may remove foundation entirely
                array_unshift($templates, sprintf('tpl/mobile/tpl-mobile-%s.php', self::$base_tpl));
            }
        } else {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/layout/tbs-index.php','tpl/themes/index.php','tpl/layout/tpl-index.php','tpl/layout/index.php',);
            if (self::$base_tpl) {

                //foundation themes  - may remove foundation entirely
                //array_unshift($templates, sprintf('tpl/sample/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/layout/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/themes/tpl-%s.php', self::$base_tpl));
                //array_unshift($templates, sprintf('tpl/custom/tpl-%s.php', self::$base_tpl));
                //twitter bootstrap themes
                //array_unshift($templates, sprintf('tpl/sample/tpl-tbs-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/layout/tpl-tbs-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/themes/tpl-tbs-%s.php', self::$base_tpl));
               // array_unshift($templates, sprintf('tpl/custom/tpl-tbs-%s.php', self::$base_tpl));
            }
        }

        return locate_template($templates);

        //self::locate_tpl($template_names, $slug, $load, $require_once)
       // return self::locate_tpl($templates);

    }

    /**
     *
     * @param string $template_names
     * @param string $slug null
     * @param bool $load false
     * @param bool $require_once true
     * @return string
     */
    public static function locate_tpl($template_names, $slug=null, $load = false, $require_once = true) {
        $located = '';
        $path = 'tpl/';
        if (isset($slug)) $path = "tpl/{$slug}/";
        foreach ((array) $template_names as $template_name) {
            if (!$template_name)
                continue;
            if (file_exists(STYLESHEETPATH . "/{$path}" . $template_name)) {
                $located = STYLESHEETPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . "/{$path}" . $template_name)) {
                $located = TEMPLATEPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
                $located = STYLESHEETPATH . '/' . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . '/' . $template_name)) {
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            } else if (file_exists(CWP_PATH . "/{$path}" . $template_name)) {
                $located = CWP_PATH . "/{$path}" . $template_name;
                break;
            }
        }


        if ($load && '' != $located)
            load_template($located, $require_once);
        return $located;
    }


    public static function post_tpl($name=null,$post_query=null) {
        $tpl = '/'.$name.'.php';
        $cwp_query = $post_query;
        if(file_exists(get_stylesheet_directory().$tpl)){
            include_once get_stylesheet_directory().$tpl;
            return;
        } elseif (file_exists(get_template_directory().$tpl)){
            include_once get_template_directory().$tpl;
            return;
        }
    }


    /**
     * Use wordpress get_template part to retrieve template flies in the tpl directory
     * @param type $slug
     * @param type $name
     */
    public static function get_template_part($slug='base',$name){
        //check slug dir
        $dir_slug = false;

        $tpl_dir = '/tpl/'.$slug;
        //check if the directory exists
        if(file_exists(get_template_directory().$tpl_dir) AND is_dir(get_template_directory().$tpl_dir)) {$dir_slug = true;}

        if(file_exists(get_stylesheet_directory().$tpl_dir) AND is_dir(get_stylesheet_directory().$tpl_dir)) {$dir_slug = TRUE;}

        if($dir_slug):
            get_template_part($tpl_dir, $name);
            else :
            get_template_part('tpl/base', $slug.'-'.$name);
        endif;


    }


    /**
     *
     * returns a file name based on wordpress template file conditional functions for use in cwp layout
     * @global type $wp_query
     * @param string $_prefix tpl prefix default - header. if null is empty
     * @return string
     */
    public static function tpl_conditional($_prefix='header'){
        $prefix = 'index';
        if(isset($_prefix))
            $prefix="{$_prefix}-";
        //set up global
       global $wp_query;
        $id = $wp_query->get_queried_object_id();
        $object = $wp_query->get_queried_object();

        $template = get_post_meta($id, '_wp_page_template', true);
        $cwp_template = get_post_meta($id, '_cwp_page_template', true);
        //create a default template array
        $templates = array();

        if(is_home()){
            $templates[] = "{$prefix}home.php";
        }

        elseif(is_front_page()){
            $templates[] = "{$prefix}front-page.php";
        }


        elseif (is_single()) {

            $templates[] = "{$prefix}$cwp_template";
            $templates[] = "{$prefix}single-{$object->post_type}.php";
            $templates[] = "{$prefix}single.php";
        }

        elseif (is_page()) {
            $pagename = get_query_var('pagename');
            if (!empty($template) && !validate_file($template))
            $templates[] = "{$prefix}{$template}";
        elseif ($pagename)
            $templates[] = "{$prefix}page-{$pagename}.php";
        $templates[] = "{$prefix}page.php";


        }


        elseif (is_category()) {
            $templates[] = "{$prefix}category-{$object->slug}.php";
            $templates[] = "{$prefix}category-{$object->term_id}.php";
            $templates[] = "{$prefix}category.php";

        }

        elseif (is_archive() OR is_post_type_archive()) {
             $post_type = get_query_var('post_type');
            if ($post_type)
                $templates[] = "{$prefix}archive-{$post_type}.php";
            $templates[] = "{$prefix}archive.php";
        }

        elseif(is_search()){
            $templates[] = "{$prefix}search";

        }

        elseif(is_tag()){
        $templates[] = "{$prefix}tag-{$object->slug}.php";
        $templates[] = "{$prefix}tag.php";

        }

        elseif(is_tax()){
            $taxonomy = $object->taxonomy;
        $templates[] = "{$prefix}taxonomy-$taxonomy-{$term->slug}.php";
        $templates[] = "{$prefix}taxonomy-$taxonomy.php";
        $templates[] = "{$prefix}taxonomy.php";
        }

        elseif (is_author()){
            $templates[] = "{$prefix}author-{$object->user_nicename}.php";
            $templates[] = "{$prefix}author.php";
        }

        elseif(is_date()){
            $templates[] = "{$prefix}date.php";
        }


        elseif(is_404()){
            $templates[] = "{$prefix}404.php";
        }

        /*
        if(is_attachment()):
            global $posts;
        $type = explode('/', $posts[0]->post_mime_type);
        if ($template = $this->get_query_template($type[0]))
            return $template;
        elseif ($template = $this->get_query_template($type[1]))
            return $template;
        elseif ($template = $this->get_query_template("$type[0]_$type[1]"))
            return $template;
        else
            return $this->get_query_template('attachment');

        endif;
         */

        $templates[] = "{$_prefix}.php";
        return $templates;


    }



}