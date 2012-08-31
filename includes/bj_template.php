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
            return  get_bloginfo('name');
        endif;
    }

}

?>
