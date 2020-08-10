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
    const AMAZINGZOOM_Xoffset = 'AMAZINGZOOM_Xoffset';
    const AMAZINGZOOM_Yoffset = 'AMAZINGZOOM_Yoffset';
    const AMAZINGZOOM_fadeIn = 'AMAZINGZOOM_fadeIn';
    const AMAZINGZOOM_fadeOut = 'AMAZINGZOOM_fadeOut';
    const AMAZINGZOOM_defaultScale = 'AMAZINGZOOM_defaultScale';
    const AMAZINGZOOM_scroll = 'AMAZINGZOOM_scroll';
    const AMAZINGZOOM_tint = 'AMAZINGZOOM_tint';
    const AMAZINGZOOM_tintOpacity = 'AMAZINGZOOM_tintOpacity';
    const AMAZINGZOOM_lens = 'AMAZINGZOOM_lens';
    const AMAZINGZOOM_lensOpacity = 'AMAZINGZOOM_lensOpacity';
    const AMAZINGZOOM_lensShape = 'AMAZINGZOOM_lensShape';
    const AMAZINGZOOM_lensCollision = 'AMAZINGZOOM_lensCollision';
    const AMAZINGZOOM_title = 'AMAZINGZOOM_title';
    const AMAZINGZOOM_bg = 'AMAZINGZOOM_bg';

    public static function getDefaultConfig()
    {
        return array (
            self::AMAZINGZOOM_position => 'right',
            self::AMAZINGZOOM_mposition  => 'inside',
            self::AMAZINGZOOM_Xoffset  => 0,
            self::AMAZINGZOOM_Yoffset  => 0,
            self::AMAZINGZOOM_fadeIn  => true,
            self::AMAZINGZOOM_fadeOut  => false,
            self::AMAZINGZOOM_defaultScale  => 0,
            self::AMAZINGZOOM_scroll  => true,
            self::AMAZINGZOOM_tint  => false,
            self::AMAZINGZOOM_tintOpacity  => 0.5,
            self::AMAZINGZOOM_lens  => false,
            self::AMAZINGZOOM_lensOpacity  => 0.5,
            self::AMAZINGZOOM_lensShape  => 'box',
            self::AMAZINGZOOM_lensCollision  => true,
            self::AMAZINGZOOM_title  => false,
            self::AMAZINGZOOM_bg  => false
        );
    }
}
