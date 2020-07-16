<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

require_once 'MyBasicEnum.php';

abstract class ModuleDisplay extends MyBasicEnum
{
    const Default_Settings = 1;
    const Product_Page = 2;
    const Category_Page = 3;
    const Manufacturer_Page = 4;
    const NewProducts_Page = 5;
    const NewProducts_Sideabr = 6;
    const NewProduct_Block = 7;
    const Bestsellers_Page = 8;
    const Bestsellers_Sidebar = 9;
    const Bestsellers_Block = 10;
    const Specials_Page = 11;
    const Specials_Sidebar = 12;
    const Specials_Block = 13;
    const Viewed_Sidebar = 14;
    const Featured_Block = 15;
    const Search_Page = 16;

    public static function  getConstantsWithSpaces()
    {
        $constants = self::getConstants();
        $public_constants = array();
        foreach ($constants as $key => $value) {
            $public_constants[self::addSpaces($key)] = $value;
        }

        return $public_constants;
    }

    private static function addSpaces($name)
    {
        return str_replace('_', ' ', $name);
    }
}
