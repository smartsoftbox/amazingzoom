<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

abstract class Config
{
    const AMAZINGZOOM_position = 'AMAZINGZOOM_position';
    const AMAZINGZOOM_mposition  = 'AMAZINGZOOM_mposition';
    const AMAZINGZOOM_rootOutput = 'AMAZINGZOOM_rootOutput';
    const AMAZINGZOOM_Xoffset = 'AMAZINGZOOM_Xoffset';
    const AMAZINGZOOM_Yoffset = 'AMAZINGZOOM_Yoffset';
    const AMAZINGZOOM_fadeIn = 'AMAZINGZOOM_fadeIn';
    const AMAZINGZOOM_fadeTrans = 'AMAZINGZOOM_fadeTrans';
    const AMAZINGZOOM_fadeOut = 'AMAZINGZOOM_fadeOut';
    const AMAZINGZOOM_smoothZoomMove = 'AMAZINGZOOM_smoothZoomMove';
    const AMAZINGZOOM_smoothLensMove = 'AMAZINGZOOM_smoothLensMove';
    const AMAZINGZOOM_smoothScale = 'AMAZINGZOOM_smoothScale';
    const AMAZINGZOOM_defaultScale = 'AMAZINGZOOM_defaultScale';
    const AMAZINGZOOM_scroll = 'AMAZINGZOOM_scroll';
    const AMAZINGZOOM_tint = 'AMAZINGZOOM_tint';
    const AMAZINGZOOM_tintOpacity = 'AMAZINGZOOM_tintOpacity';
    const AMAZINGZOOM_lens = 'AMAZINGZOOM_lens';
    const AMAZINGZOOM_lensOpacity = 'AMAZINGZOOM_lensOpacity';
    const AMAZINGZOOM_lensShape = 'AMAZINGZOOM_lensShape';
    const AMAZINGZOOM_lensCollision = 'AMAZINGZOOM_lensCollision';
    const AMAZINGZOOM_lensReverse = 'AMAZINGZOOM_lensReverse';
    const AMAZINGZOOM_openOnSmall = 'AMAZINGZOOM_openOnSmall';
    const AMAZINGZOOM_zoomWidth = 'AMAZINGZOOM_zoomWidth';
    const AMAZINGZOOM_zoomHeight = 'AMAZINGZOOM_zoomHeight';
    const AMAZINGZOOM_sourceClass = 'AMAZINGZOOM_sourceClass';
    const AMAZINGZOOM_loadingClass = 'AMAZINGZOOM_loadingClass';
    const AMAZINGZOOM_lensClass = 'AMAZINGZOOM_lensClass';
    const AMAZINGZOOM_zoomClass = 'AMAZINGZOOM_zoomClass';
    const AMAZINGZOOM_activeClass = 'AMAZINGZOOM_activeClass';
    const AMAZINGZOOM_hover = 'AMAZINGZOOM_hover';
    const AMAZINGZOOM_adaptive = 'AMAZINGZOOM_adaptive';
    const AMAZINGZOOM_adaptiveReverse = 'AMAZINGZOOM_adaptiveReverse';
    const AMAZINGZOOM_title = 'AMAZINGZOOM_title';
    const AMAZINGZOOM_titleClass = 'AMAZINGZOOM_titleClass';
    const AMAZINGZOOM_bg = 'AMAZINGZOOM_bg';

    public static function getDefaultConfig()
    {
        return array (
            self::AMAZINGZOOM_position => 'right',
            self::AMAZINGZOOM_mposition  => 'inside',
            self::AMAZINGZOOM_rootOutput  => true,
            self::AMAZINGZOOM_Xoffset  => 0,
            self::AMAZINGZOOM_Yoffset  => 0,
            self::AMAZINGZOOM_fadeIn  => true,
            self::AMAZINGZOOM_fadeTrans  => true,
            self::AMAZINGZOOM_fadeOut  => false,
            self::AMAZINGZOOM_smoothZoomMove  => 3,
            self::AMAZINGZOOM_smoothLensMove  => 1,
            self::AMAZINGZOOM_smoothScale  => 6,
            self::AMAZINGZOOM_defaultScale  => 0,
            self::AMAZINGZOOM_scroll  => true,
            self::AMAZINGZOOM_tint  => false,
            self::AMAZINGZOOM_tintOpacity  => 0.5,
            self::AMAZINGZOOM_lens  => false,
            self::AMAZINGZOOM_lensOpacity  => 0.5,
            self::AMAZINGZOOM_lensShape  => 'box',
            self::AMAZINGZOOM_lensCollision  => true,
            self::AMAZINGZOOM_lensReverse  => false,
            self::AMAZINGZOOM_openOnSmall  => true,
            self::AMAZINGZOOM_zoomWidth  => 'auto',
            self::AMAZINGZOOM_zoomHeight  => 'auto',
            self::AMAZINGZOOM_sourceClass  => 'xzoom-source',
            self::AMAZINGZOOM_loadingClass  => 'xzoom-loading',
            self::AMAZINGZOOM_lensClass  => 'xzoom-lens',
            self::AMAZINGZOOM_zoomClass  => 'xzoom-preview',
            self::AMAZINGZOOM_activeClass  => 'xactive',
            self::AMAZINGZOOM_hover  => false,
            self::AMAZINGZOOM_adaptive  => true,
            self::AMAZINGZOOM_adaptiveReverse  => false,
            self::AMAZINGZOOM_title  => false,
            self::AMAZINGZOOM_titleClass  => 'xzoom-caption',
            self::AMAZINGZOOM_bg  => false
        );
    }
}
