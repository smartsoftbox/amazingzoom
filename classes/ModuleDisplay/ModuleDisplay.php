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
    protected $css_selector;
    protected $js;
    protected $css;
    protected $use_default;
    protected $is_enable;
    protected $position;
    protected $mposition;
    protected $rootOutput;
    protected $Xoffset;
    protected $Yoffset;
    protected $fadeIn;
    protected $fadeTrans;
    protected $fadeOut;
    protected $smoothZoomMove;
    protected $smoothLensMove;
    protected $smoothScale;
    protected $defaultScale;
    protected $scroll;
    protected $tint;
    protected $tintOpacity;
    protected $lens;
    protected $lensOpacity;
    protected $lensShape;
    protected $lensCollision;
    protected $lensReverse;
    protected $openOnSmall;
    protected $zoomWidth;
    protected $zoomHeight;
    protected $hover;
    protected $adaptive;
    protected $adaptiveReverse;
    protected $title;
    protected $bg;

    //photoswipe
    protected $swipe_is_enable;
    protected $swipe_showHideOpacity;
    protected $swipe_showAnimationDuration;
    protected $swipe_hideAnimationDuration;
    protected $swipe_bgOpacity;
    protected $swipe_spacing;
    protected $swipe_allowPanToNext;
    protected $swipe_maxSpreadZoom;
    protected $swipe_loop;
    protected $swipe_pinchToClose;
    protected $swipe_closeOnScroll;
    protected $swipe_closeOnVerticalDrag;
    protected $swipe_arrowKeys;
    protected $swipe_history;
    protected $swipe_modal;
    protected $thumb_selector;
    protected $image_type;

    protected function getJS()
    {
        $js = str_replace('<script>', '', $this->js);
        $js = str_replace('</script>', '', $js);
        $js = trim($js);
        $js = str_replace('{css_selector}', $this->css_selector, $js);

        return pSQL($js);
    }

    protected function getCSS()
    {
        $css = str_replace('<style>', '', $this->css);
        $css = str_replace('</style>', '', $css);
        $css = trim($css);
        $css = str_replace('{css_selector}',  $this->css_selector, $css);

        return pSQL($css);
    }

    public function save()
    {
        $amazingZoomClass = new AmazingZoomClass();
        $amazingZoomClass->name = $this->name;
        $amazingZoomClass->controller = implode(',', $this->controller);
        $amazingZoomClass->css_selector = $this->css_selector;
        $amazingZoomClass->thumb_selector = $this->thumb_selector;
        $amazingZoomClass->image_type = $this->image_type;

        $amazingZoomClass->css = $this->getCSS();
        $amazingZoomClass->js = $this->getJS();
        $amazingZoomClass->use_default = $this->use_default;
        $amazingZoomClass->is_enable = $this->is_enable;
        $amazingZoomClass->position = $this->position;
        $amazingZoomClass->mposition = $this->mposition;
        $amazingZoomClass->rootOutput = $this->rootOutput;
        $amazingZoomClass->Xoffset = $this->Xoffset;
        $amazingZoomClass->Yoffset = $this->Yoffset;
        $amazingZoomClass->fadeIn = $this->fadeIn;
        $amazingZoomClass->fadeTrans = $this->fadeTrans;
        $amazingZoomClass->fadeOut = $this->fadeOut;
        $amazingZoomClass->smoothZoomMove = $this->smoothZoomMove;
        $amazingZoomClass->smoothLensMove = $this->smoothLensMove;
        $amazingZoomClass->smoothScale = $this->smoothScale;
        $amazingZoomClass->defaultScale = $this->defaultScale;
        $amazingZoomClass->scroll = $this->scroll;
        $amazingZoomClass->tint = $this->tint;
        $amazingZoomClass->tintOpacity = $this->tintOpacity;
        $amazingZoomClass->lens = $this->lens;
        $amazingZoomClass->lensOpacity = $this->lensOpacity;
        $amazingZoomClass->lensShape = $this->lensShape;
        $amazingZoomClass->lensCollision = $this->lensCollision;
        $amazingZoomClass->lensReverse = $this->lensReverse;
        $amazingZoomClass->openOnSmall = $this->openOnSmall;
        $amazingZoomClass->zoomWidth = $this->zoomWidth;
        $amazingZoomClass->zoomHeight = $this->zoomHeight;
        $amazingZoomClass->hover = $this->hover;
        $amazingZoomClass->adaptive = $this->adaptive;
        $amazingZoomClass->adaptiveReverse = $this->adaptiveReverse;
        $amazingZoomClass->title = $this->title;
        $amazingZoomClass->bg = $this->bg;

        $amazingZoomClass->swipe_is_enable = $this->swipe_is_enable;
        $amazingZoomClass->swipe_showHideOpacity = $this->swipe_showHideOpacity;
        $amazingZoomClass->swipe_showAnimationDuration = $this->swipe_showAnimationDuration;
        $amazingZoomClass->swipe_hideAnimationDuration = $this->swipe_hideAnimationDuration;
        $amazingZoomClass->swipe_bgOpacity = $this->swipe_bgOpacity;
        $amazingZoomClass->swipe_spacing = $this->swipe_spacing;
        $amazingZoomClass->swipe_allowPanToNext = $this->swipe_allowPanToNext;
        $amazingZoomClass->swipe_maxSpreadZoom = $this->swipe_maxSpreadZoom;
        $amazingZoomClass->swipe_loop = $this->swipe_loop;
        $amazingZoomClass->swipe_pinchToClose = $this->swipe_pinchToClose;
        $amazingZoomClass->swipe_closeOnScroll = $this->swipe_closeOnScroll;
        $amazingZoomClass->swipe_closeOnVerticalDrag = $this->swipe_closeOnVerticalDrag;
        $amazingZoomClass->swipe_arrowKeys = $this->swipe_arrowKeys;
        $amazingZoomClass->swipe_history = $this->swipe_history;
        $amazingZoomClass->swipe_modal = $this->swipe_modal;

        $amazingZoomClass->save();
    }
}
