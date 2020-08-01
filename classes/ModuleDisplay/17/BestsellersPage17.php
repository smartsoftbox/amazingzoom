<?php
/**
 * 2020 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

require_once dirname(__FILE__) . '/../ModuleDisplay.php';


class BestsellersPage17 extends ModuleDisplay
{

    public $name = 'Bestsellers Page';
    public $controller = array('best-sales');
    public $id_page = 8;
    public $css_selector = '.js-qv-product-cover, .thumbs';
    public $js = '';
    public $css = '';
    public $use_default = false;
    public $is_enable = true;
    public $position = 'inside';
    public $mposition = 'inside';
    public $rootOutput = true;
    public $Xoffset = 0;
    public $Yoffset = 0;
    public $fadeIn = true;
    public $fadeTrans = true;
    public $fadeOut = false;
    public $smoothZoomMove = 3;
    public $smoothLensMove = 1;
    public $smoothScale = 6;
    public $defaultScale = 0;
    public $scroll = true;
    public $tint = false;
    public $tintOpacity = 0.5;
    public $lens = false;
    public $lensOpacity = 0.5;
    public $lensShape = 'box';
    public $lensCollision = true;
    public $lensReverse = false;
    public $openOnSmall = true;
    public $zoomWidth = 'auto';
    public $zoomHeight = 'auto';
    public $hover = false;
    public $adaptive = true;
    public $adaptiveReverse = false;
    public $title = false;
    public $bg = false;

    //photoswipe
    public $swipe_is_enable = true;
    public $swipe_showHideOpacity = false;
    public $swipe_showAnimationDuration = 333;
    public $swipe_hideAnimationDuration = 334;
    public $swipe_bgOpacity = 1;
    public $swipe_spacing = 0.22;
    public $swipe_allowPanToNext = true;
    public $swipe_maxSpreadZoom = 2;
    public $swipe_loop = true;
    public $swipe_pinchToClose = true;
    public $swipe_closeOnScroll = true;
    public $swipe_closeOnVerticalDrag = true;
    public $swipe_arrowKeys = true;
    public $swipe_history = true;
    public $swipe_modal = true;
    public $thumb_selector = '';
    public $image_type = 'upload';

}
