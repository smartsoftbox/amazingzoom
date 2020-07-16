<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

class AmazingZoomUninstall
{

    public $module;

    public function __construct($module)
    {
        $this->module = $module;
    }

    public function run()
    {
        $tables = array('amazingzoom');

        return self::dropTables($tables);
    }

    public static function dropTables($tables)
    {
        if (!is_array($tables)) {
            $tables = array($tables);
        }

        foreach ($tables as $table) {
            if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . $table . '`')) {
                return false;
            }
        }

        return true;
    }
}
