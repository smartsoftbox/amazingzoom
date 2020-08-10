<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

class AmazingZoomClass extends ObjectModel
{
    public $id;
    public $use_default;
    public $is_enable;
    public $position;
    public $mposition ;
    public $Xoffset;
    public $Yoffset;
    public $fadeIn;
    public $fadeOut;
    public $defaultScale;
    public $scroll;
    public $tint;
    public $tintOpacity;
    public $lens;
    public $lensOpacity;
    public $lensShape;
    public $lensCollision;
    public $title;
    public $bg;

    //photoswipe
    public $swipe_is_enable;
    public $swipe_showHideOpacity;
    public $swipe_showAnimationDuration;
    public $swipe_hideAnimationDuration;
    public $swipe_bgOpacity;
    public $swipe_spacing;
    public $swipe_allowPanToNext;
    public $swipe_maxSpreadZoom;
    public $swipe_loop;
    public $swipe_pinchToClose;
    public $swipe_closeOnScroll;
    public $swipe_closeOnVerticalDrag;
    public $swipe_arrowKeys;
    public $swipe_modal;

    public $controller;
    public $name;
    public $css_selector;
    public $thumb_selector;
    public $image_type;

    public $css;
    public $js;

    public static $definition = array(
        'table' => 'amazingzoom',
        'primary' => 'id_amazingzoom',
    );

    public function copyFromPost($id_amazingzoom)
    {
        /* Classical fields */
        foreach ($_POST as $key => $value) {
            $key = str_replace('_' . $id_amazingzoom, '', $key);
            if (key_exists($key, $this) and $key != 'id_' . $this->table) {
                $this->{$key} = $value;
            }
        }
    }

    public static function getDefaultSettingsId()
    {
        return Db::getInstance()->getValue(
            'SELECT `id_amazingzoom` FROM `' . _DB_PREFIX_ . 'amazingzoom` WHERE name = "Default Settings"'
        );
    }

    public static function getDefaultSettings()
    {
        return Db::getInstance()->executeS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'amazingzoom` WHERE name = "Default Settings"'
        );
    }

    public static function getAll()
    {
        $amazingzooms =  Db::getInstance()->ExecuteS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'amazingzoom`'
        );

        foreach ($amazingzooms as $key => $amazingzoom) {
            if($amazingzoom['name'] === "Default Settings") {
                unset($amazingzooms[$key]);
                array_unshift($amazingzooms , $amazingzoom);
            }
        }

        return $amazingzooms;
    }

    public static function getEnabled()
    {
        return Db::getInstance()->ExecuteS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'amazingzoom` WHERE 
            name != "Default Settings" AND is_enable = 1 OR name != "Default Settings" AND swipe_is_enable = 1 '
        );
    }

    public function getFields()
    {
        parent::validateFields();
        $fields = null;
        $fields['id_amazingzoom'] = (int)($this->id);
        $fields['use_default'] = (bool)$this->use_default;
        $fields['is_enable'] = (bool)$this->is_enable;
        $fields['position'] = $this->position;
        $fields['mposition'] = $this->mposition;
        $fields['Xoffset'] = $this->Xoffset;
        $fields['Yoffset'] = $this->Yoffset;
        $fields['fadeIn'] = $this->fadeIn;
        $fields['fadeOut'] = $this->fadeOut;
        $fields['defaultScale'] = $this->defaultScale;
        $fields['scroll'] = $this->scroll;
        $fields['tint'] = $this->tint;
        $fields['tintOpacity'] = $this->tintOpacity;
        $fields['lens'] = $this->lens;
        $fields['lensOpacity'] = $this->lensOpacity;
        $fields['lensShape'] = $this->lensShape;
        $fields['lensCollision'] = $this->lensCollision;
        $fields['title'] = $this->title;
        $fields['bg'] = $this->bg;

        //photoswipe
        $fields['swipe_is_enable'] = $this->swipe_is_enable;
        $fields['swipe_showHideOpacity'] = $this->swipe_showHideOpacity;
        $fields['swipe_showAnimationDuration'] = $this->swipe_showAnimationDuration;
        $fields['swipe_hideAnimationDuration'] = $this->swipe_hideAnimationDuration;
        $fields['swipe_bgOpacity'] = $this->swipe_bgOpacity;
        $fields['swipe_spacing'] = $this->swipe_spacing;
        $fields['swipe_allowPanToNext'] = $this->swipe_allowPanToNext;
        $fields['swipe_maxSpreadZoom'] = $this->swipe_maxSpreadZoom;
        $fields['swipe_loop'] = $this->swipe_loop;
        $fields['swipe_pinchToClose'] = $this->swipe_pinchToClose;
        $fields['swipe_closeOnScroll'] = $this->swipe_closeOnScroll;
        $fields['swipe_closeOnVerticalDrag'] = $this->swipe_closeOnVerticalDrag;
        $fields['swipe_arrowKeys'] = $this->swipe_arrowKeys;
        $fields['swipe_modal'] = $this->swipe_modal;

        $fields['controller'] = $this->controller;
        $fields['name'] = $this->name;
        $fields['css_selector'] = $this->css_selector;
        $fields['thumb_selector'] = $this->thumb_selector;
        $fields['image_type'] = $this->image_type;

        $fields['css'] = $this->css;
        $fields['js'] = $this->js;


        return $fields;
    }

    public function getDefaultValues()
    {
        $this->use_default = true;
        $this->is_enable = false;
        $this->position = 'right';
        $this->mposition  = 'inside';
        $this->Xoffset  = 0;
        $this->Yoffset  = 0;
        $this->fadeIn  = true;
        $this->fadeOut  = false;
        $this->defaultScale  = 0;
        $this->scroll  = true;
        $this->tint  = false;
        $this->tintOpacity  = 0.5;
        $this->lens  = false;
        $this->lensOpacity  = 0.5;
        $this->lensShape  = 'box';
        $this->lensCollision  = true;
        $this->title  = false;
        $this->bg  = false;
    }
}
