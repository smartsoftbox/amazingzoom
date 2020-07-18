<?php
/**
 * 2020 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

require_once 'IModuleDisplay.php';


class ProductPage implements IModuleDisplay
{
    private $name = 'Product Page';
    private $controller = 'ProductController';
    private $id_page = 2;

    private $css_selector_17 = '.product-cover img';
    private $css_selector_16 = '#bigpic';
    private $amazingZoomClass;

    public function saveDefaultValues()
    {
        $this->amazingZoomClass = new AmazingZoomClass();
        $this->amazingZoomClass->use_default = false;
        $this->amazingZoomClass->is_enable = true;
        $this->amazingZoomClass->position = 'right';
        $this->amazingZoomClass->mposition  = 'inside';
        $this->amazingZoomClass->rootOutput  = true;
        $this->amazingZoomClass->Xoffset  = 20;
        $this->amazingZoomClass->Yoffset  = 0;
        $this->amazingZoomClass->fadeIn  = true;
        $this->amazingZoomClass->fadeTrans  = true;
        $this->amazingZoomClass->fadeOut  = false;
        $this->amazingZoomClass->smoothZoomMove  = 3;
        $this->amazingZoomClass->smoothLensMove  = 1;
        $this->amazingZoomClass->smoothScale  = 6;
        $this->amazingZoomClass->defaultScale  = 0;
        $this->amazingZoomClass->scroll  = true;
        $this->amazingZoomClass->tint  = '';
        $this->amazingZoomClass->tintOpacity  = 0.5;
        $this->amazingZoomClass->lens  = '';
        $this->amazingZoomClass->lensOpacity  = 0.5;
        $this->amazingZoomClass->lensShape  = 'box';
        $this->amazingZoomClass->lensCollision  = true;
        $this->amazingZoomClass->lensReverse  = false;
        $this->amazingZoomClass->openOnSmall  = true;
        $this->amazingZoomClass->zoomWidth  = 'auto';
        $this->amazingZoomClass->zoomHeight  = 'auto';
        $this->amazingZoomClass->hover  = false;
        $this->amazingZoomClass->adaptive  = true;
        $this->amazingZoomClass->adaptiveReverse  = false;
        $this->amazingZoomClass->title  = false;
        $this->amazingZoomClass->bg  = false;

        $this->amazingZoomClass->controller = $this->controller;
        $this->amazingZoomClass->name = $this->name;
        $this->amazingZoomClass->css_selector_17 = $this->css_selector_17;
        $this->amazingZoomClass->css_selector_16 = $this->css_selector_16;

        $this->amazingZoomClass->save();
    }
}
