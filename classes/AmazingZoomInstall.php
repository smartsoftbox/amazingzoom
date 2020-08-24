<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

require_once 'Model/AmazingZoomClass.php';

class AmazingZoomInstall
{
    private $module;

    public function __construct($module)
    {
        $this->module = $module;
    }

    public function run()
    {
        self::createTable();
        self::getDefaultConfig();

        if (version_compare(_PS_VERSION_, '1.7.0', '>=') === true) {
            $this->module->registerHook('displayBeforeBodyClosingTag');
        } else {
            $this->module->registerHook('header');
        }

        return $this->module->registerHook('backOfficeHeader');
    }


    /**
     * @return bool
     */
    public static function createTable()
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'amazingzoom` (
			 `id_amazingzoom` int(10) unsigned NOT NULL auto_increment,
             `is_enable`  BOOL NOT NULL DEFAULT 0,
             `position` varchar(255) NOT NULL,
             `mposition` varchar(255) NOT NULL,
             `Xoffset` int(10) NOT NULL,
             `Yoffset` int(10) NOT NULL,
             `fadeIn` BOOL NOT NULL DEFAULT 0,
             `fadeOut` BOOL NOT NULL DEFAULT 0,
             `defaultScale` int(10) NOT NULL,
             `scroll` BOOL NOT NULL DEFAULT 0,
             `tint` varchar(255) NOT NULL,
             `tintOpacity` BOOL NOT NULL DEFAULT 0,
             `lens` varchar(255) NOT NULL,
             `lensOpacity` int(10) NOT NULL,
             `lensShape`  varchar(255) NOT NULL,
             `lensCollision`  BOOL NOT NULL DEFAULT 0,
             `title`  BOOL NOT NULL DEFAULT 0,
             `bg`  BOOL NOT NULL DEFAULT 0,
             
            `swipe_is_enable` BOOL NOT NULL DEFAULT 0,
            `swipe_showHideOpacity` BOOL NOT NULL DEFAULT 0,
            `swipe_showAnimationDuration`int(10) NOT NULL,
            `swipe_hideAnimationDuration` int(10) NOT NULL,
            `swipe_bgOpacity` float NOT NULL,
            `swipe_spacing` float NOT NULL, 
            `swipe_allowPanToNext` BOOL NOT NULL DEFAULT 0,
            `swipe_maxSpreadZoom` float NOT NULL, 
            `swipe_loop` BOOL NOT NULL DEFAULT 0,
            `swipe_pinchToClose` BOOL NOT NULL DEFAULT 0,
            `swipe_closeOnScroll` BOOL NOT NULL DEFAULT 0,
            `swipe_closeOnVerticalDrag` BOOL NOT NULL DEFAULT 0,
            `swipe_arrowKeys` BOOL NOT NULL DEFAULT 0,
            `swipe_modal` BOOL NOT NULL DEFAULT 0,
    
             `controller` varchar(255) NOT NULL,
             `name` varchar(255) NOT NULL,
             `css_selector` varchar(255) NOT NULL,
             `thumb_selector` varchar(255) NOT NULL,
             `image_type` varchar(255) NOT NULL,
 
			PRIMARY KEY  (`id_amazingzoom`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

        return Db::getInstance()->Execute($query);
    }

    public static function getDefaultConfig()
    {
        $ps_version = (_PS_VERSION_ >= 1.7 ? "17" : "16");
        foreach (glob(dirname(__FILE__) . '/ModuleDisplay/' . $ps_version . '/*.php') as $file) {
            if (strpos($file, 'ModuleDisplay.php') === false && strpos($file, 'index.php') === false) {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = basename($file, '.php');

                if (class_exists($class)) {
                    $obj = new $class;
                    $obj->save();
                }
            }
        }
    }
}
