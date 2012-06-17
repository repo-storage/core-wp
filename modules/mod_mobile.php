<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class mod_mobile extends Mobile_Detect {

    private static $instance;


    function __construct() {
        parent::__construct();
    }

    /**
     * detect if mobile is phone
     * @return boolean
     */
    public function isPhone() {
        if ($this->isAndroid() OR $this->isIphone() OR $this->isWindowsphone() OR $this->isBlackberry() ):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * detect if mobile is tablet
     * @return boolean
     */
    public function isTablet(){
        if($this->isAndroidtablet() or $this->isBlackberrytablet() or $this->isIpad()):
            return true;
        else :
            return false;
        endif;
    }

    public static function  instance(){
         if (!isset(self::$instance)) {
            self::$instance = new mod_mobile();
        }
        return self::$instance;

    }


    /**
     * class factory
     * @return \mod_mobile
     *
     */
    public static function detect() {
        return new mod_mobile;
    }




    /**
     * adds a mobile class to the body
     */
    public static function mobile_class(){
        if(mod_mobile::detect()->isMobile()) add_filter( 'body_class', array('mod_mobile','add_mobile_class'));
    }

    public function add_mobile_class($classes){
        $classes[] = 'mobile';
     return $classes;
    }

}

