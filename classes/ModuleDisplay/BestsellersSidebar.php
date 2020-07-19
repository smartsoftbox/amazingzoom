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

class BestsellersSidebar implements IModuleDisplay
{
    private $name = 'Bestsellers Sidebar';
    private $controller = 'CategoryController';
    private $id_page = 9;

    private $css_selector_17 = '.js-qv-product-cover, .thumbs';
    private $css_selector_16 = '#best-sellers .products-block-image img';
    private $amazingZoomClass;

    public function saveDefaultValues()
    {
        $this->amazingZoomClass = new AmazingZoomClass();
        $this->amazingZoomClass->use_default = false;
        $this->amazingZoomClass->is_enable = true;
        $this->amazingZoomClass->position = 'right';
        $this->amazingZoomClass->mposition  = 'inside';
        $this->amazingZoomClass->rootOutput  = true;
        $this->amazingZoomClass->Xoffset  = 0;
        $this->amazingZoomClass->Yoffset  = 0;
        $this->amazingZoomClass->fadeIn  = true;
        $this->amazingZoomClass->fadeTrans  = true;
        $this->amazingZoomClass->fadeOut  = false;
        $this->amazingZoomClass->smoothZoomMove  = 3;
        $this->amazingZoomClass->smoothLensMove  = 1;
        $this->amazingZoomClass->smoothScale  = 6;
        $this->amazingZoomClass->defaultScale  = 0;
        $this->amazingZoomClass->scroll  = true;
        $this->amazingZoomClass->tint  = false;
        $this->amazingZoomClass->tintOpacity  = 0.5;
        $this->amazingZoomClass->lens  = false;
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
