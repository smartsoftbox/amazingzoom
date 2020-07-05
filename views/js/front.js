/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(document).ready(function() {
  // document is loaded and DOM is ready
  $(".js-qv-product-cover").each(function() {
    $(this).attr('xoriginal', $(this).attr('src').replace('-large_default', ''));
  });

  /* calling script */
  $(".js-qv-product-cover, .thumbs").xzoom({
    'position': AMAIZINGZOOM_position,
    'mposition': AMAIZINGZOOM_mposition,
    'rootOutput': AMAIZINGZOOM_rootOutput,
    'Xoffset': AMAIZINGZOOM_Xoffset,
    'Yoffset': AMAIZINGZOOM_Yoffset,
    'fadeIn': AMAIZINGZOOM_fadeIn,
    'fadeTrans': AMAIZINGZOOM_fadeTrans,
    'fadeOut': AMAIZINGZOOM_fadeOut,
    'smoothZoomMove': AMAIZINGZOOM_smoothZoomMove,
    'smoothLensMove': AMAIZINGZOOM_smoothLensMove,
    'smoothScale': AMAIZINGZOOM_smoothScale,
    'defaultScale': AMAIZINGZOOM_defaultScale,
    'scroll': AMAIZINGZOOM_scroll,
    'tint': AMAIZINGZOOM_tint,
    'tintOpacity': AMAIZINGZOOM_tintOpacity,
    'lens': AMAIZINGZOOM_lens,
    'lensOpacity': AMAIZINGZOOM_lensOpacity,
    'lensShape': AMAIZINGZOOM_lensShape,
    'lensCollision': AMAIZINGZOOM_lensCollision,
    'lensReverse': AMAIZINGZOOM_lensReverse,
    'openOnSmall': AMAIZINGZOOM_openOnSmall,
    'zoomWidth': AMAIZINGZOOM_zoomWidth,
    'zoomHeight': AMAIZINGZOOM_zoomHeight,
    'sourceClass': AMAIZINGZOOM_sourceClass,
    'loadingClass': AMAIZINGZOOM_loadingClass,
    'lensClass': AMAIZINGZOOM_lensClass,
    'zoomClass': AMAIZINGZOOM_zoomClass,
    'activeClass': AMAIZINGZOOM_activeClass,
    'hover': AMAIZINGZOOM_hover,
    'adaptive': AMAIZINGZOOM_adaptive,
    'adaptiveReverse': AMAIZINGZOOM_adaptiveReverse,
    'title': AMAIZINGZOOM_title,
    'titleClass': AMAIZINGZOOM_titleClass,
    'bg': AMAIZINGZOOM_bg
  });

});
