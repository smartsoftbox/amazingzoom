<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

require_once 'Data/ModuleDisplay.php';
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
             `use_default` BOOL NOT NULL DEFAULT 0,
             `is_enable`  BOOL NOT NULL DEFAULT 0,
             `position` varchar(255) NOT NULL,
             `mposition` varchar(255) NOT NULL,
             `rootOutput` BOOL NOT NULL DEFAULT 0,
             `Xoffset` int(10) NOT NULL,
             `Yoffset` int(10) NOT NULL,
             `fadeIn` BOOL NOT NULL DEFAULT 0,
             `fadeTrans` BOOL NOT NULL DEFAULT 0,
             `fadeOut` BOOL NOT NULL DEFAULT 0,
             `smoothZoomMove` int(10) NOT NULL,
             `smoothLensMove` int(10) NOT NULL,
             `smoothScale` int(10) NOT NULL,
             `defaultScale` int(10) NOT NULL,
             `scroll` BOOL NOT NULL DEFAULT 0,
             `tint` varchar(255) NOT NULL,
             `tintOpacity` BOOL NOT NULL DEFAULT 0,
             `lens` varchar(255) NOT NULL,
             `lensOpacity` int(10) NOT NULL,
             `lensShape`  BOOL NOT NULL DEFAULT 0,
             `lensCollision`  BOOL NOT NULL DEFAULT 0,
             `lensReverse`  BOOL NOT NULL DEFAULT 0,
             `openOnSmall`  BOOL NOT NULL DEFAULT 0,
             `zoomWidth` varchar(255) NOT NULL,
             `zoomHeight` varchar(255) NOT NULL,
             `hover`  BOOL NOT NULL DEFAULT 0,
             `adaptive`  BOOL NOT NULL DEFAULT 0,
             `adaptiveReverse`  BOOL NOT NULL DEFAULT 0,
             `title`  BOOL NOT NULL DEFAULT 0,
             `bg`  BOOL NOT NULL DEFAULT 0,
             
             `controller` varchar(255) NOT NULL,
             `name` varchar(255) NOT NULL,
             `css_selector_17` varchar(255) NOT NULL,
             `css_selector_16` varchar(255) NOT NULL,
			PRIMARY KEY  (`id_amazingzoom`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

        return Db::getInstance()->Execute($query);
    }

    public static function getDefaultConfig()
    {
        foreach (glob(dirname(__FILE__) . '/ModuleDisplay/*.php') as $file)
        {
            if( strpos( $file, 'IModuleDisplay' ) !== true) {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = basename($file, '.php');

                if (class_exists($class)) {
                    $obj = new $class;
                    $obj->saveDefaultValues();
                }
            }
        }
    }
}
