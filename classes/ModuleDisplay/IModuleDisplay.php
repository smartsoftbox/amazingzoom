<?php
/**
 * 2020 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

interface IModuleDisplay
{
    public function saveDefaultValues();
    public function getJS17();
    public function getJS16();
    public function getCSS17();
    public function getCSS16();
}
