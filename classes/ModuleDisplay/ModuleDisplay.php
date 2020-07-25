<?php
/**
 * 2020 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

abstract class ModuleDisplay
{
    protected $name;
    protected $controller;
    protected $id_page;
    protected $css_selector_17;
    protected $css_selector_16;
    protected $amazingZoomClass;

    abstract function saveDefaultValues();
    abstract function getJS17();
    abstract function getJS16();
    abstract function getCSS17();
    abstract function getCSS16();

    protected function getCssSelector()
    {
       return (_PS_VERSION_ >= 1.7 ? $this->css_selector_17 : $this->css_selector_16);
    }

    protected function getJS()
    {
        $js = (_PS_VERSION_ >= 1.7 ? $this->getJS17() : $this->getJS16());
        $js = str_replace('<script>', '', $js);
        $js = str_replace('</script>', '', $js);
        $js = trim($js);
        $js = str_replace('{css_selector}', $this->getCssSelector(), $js);

        return pSQL($js);
    }

    protected function getCSS()
    {
        $css = (_PS_VERSION_ >= 1.7 ? $this->getCSS17() : $this->getCSS16());
        $css = str_replace('<style>', '', $css);
        $css = str_replace('</style>', '', $css);
        $css = trim($css);
        $css = str_replace('{css_selector}', $this->getCssSelector(), $css);

        return pSQL($css);
    }
}
