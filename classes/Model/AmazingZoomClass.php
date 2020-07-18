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
    public $rootOutput;
    public $Xoffset;
    public $Yoffset;
    public $fadeIn;
    public $fadeTrans;
    public $fadeOut;
    public $smoothZoomMove;
    public $smoothLensMove;
    public $smoothScale;
    public $defaultScale;
    public $scroll;
    public $tint;
    public $tintOpacity;
    public $lens;
    public $lensOpacity;
    public $lensShape;
    public $lensCollision;
    public $lensReverse;
    public $openOnSmall;
    public $zoomWidth;
    public $zoomHeight;
    public $hover;
    public $adaptive;
    public $adaptiveReverse;
    public $title;
    public $bg;

    public $controller;
    public $name;
    public $css_selector_17;
    public $css_selector_16;

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
            'SELECT * FROM `' . _DB_PREFIX_ . 'amazingzoom` WHERE is_enable = 1'
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
        $fields['rootOutput'] = $this->rootOutput;
        $fields['Xoffset'] = $this->Xoffset;
        $fields['Yoffset'] = $this->Yoffset;
        $fields['fadeIn'] = $this->fadeIn;
        $fields['fadeTrans'] = $this->fadeTrans;
        $fields['fadeOut'] = $this->fadeOut;
        $fields['smoothZoomMove'] = $this->smoothZoomMove;
        $fields['smoothLensMove'] = $this->smoothLensMove;
        $fields['smoothScale'] = $this->smoothScale;
        $fields['defaultScale'] = $this->defaultScale;
        $fields['scroll'] = $this->scroll;
        $fields['tint'] = $this->tint;
        $fields['tintOpacity'] = $this->tintOpacity;
        $fields['lens'] = $this->lens;
        $fields['lensOpacity'] = $this->lensOpacity;
        $fields['lensShape'] = $this->lensShape;
        $fields['lensCollision'] = $this->lensCollision;
        $fields['lensReverse'] = $this->lensReverse;
        $fields['openOnSmall'] = $this->openOnSmall;
        $fields['zoomWidth'] = $this->zoomWidth;
        $fields['zoomHeight'] = $this->zoomHeight;
        $fields['hover'] = $this->hover;
        $fields['adaptive'] = $this->adaptive;
        $fields['adaptiveReverse'] = $this->adaptiveReverse;
        $fields['title'] = $this->title;
        $fields['bg'] = $this->bg;

        $fields['controller'] = $this->controller;
        $fields['name'] = $this->name;
        $fields['css_selector_17'] = $this->css_selector_17;
        $fields['css_selector_16'] = $this->css_selector_16;

        return $fields;
    }

    public function getDefaultValues()
    {
        $this->use_default = true;
        $this->is_enable = false;
        $this->position = 'right';
        $this->mposition  = 'inside';
        $this->rootOutput  = true;
        $this->Xoffset  = 0;
        $this->Yoffset  = 0;
        $this->fadeIn  = true;
        $this->fadeTrans  = true;
        $this->fadeOut  = false;
        $this->smoothZoomMove  = 3;
        $this->smoothLensMove  = 1;
        $this->smoothScale  = 6;
        $this->defaultScale  = 0;
        $this->scroll  = true;
        $this->tint  = false;
        $this->tintOpacity  = 0.5;
        $this->lens  = false;
        $this->lensOpacity  = 0.5;
        $this->lensShape  = 'box';
        $this->lensCollision  = true;
        $this->lensReverse  = false;
        $this->openOnSmall  = true;
        $this->zoomWidth  = 'auto';
        $this->zoomHeight  = 'auto';
        $this->hover  = false;
        $this->adaptive  = true;
        $this->adaptiveReverse  = false;
        $this->title  = false;
        $this->bg  = false;
    }
}
