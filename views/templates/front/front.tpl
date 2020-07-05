{*
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
*}
<script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/xzoom.js'></script>
<link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/xzoom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    $(document).ready(function () {
        //hide layer
        $('.product-cover').find('.layer').css('display', 'none');
        // document is loaded and DOM is ready
        $(".js-qv-product-cover").each(function () {
            $(this).attr('xoriginal', $(this).attr('src').replace('-large_default', ''));
            $(this).click(function() {
                $('.product-cover').find('.layer').click();
            });
        });


        /* calling script */
        $(".js-qv-product-cover, .thumbs").xzoom({
            'position': '{$AMAZINGZOOM_position}',
            'mposition': '{$AMAZINGZOOM_mposition}',
            'rootOutput': {$AMAZINGZOOM_rootOutput},
            'Xoffset': {$AMAZINGZOOM_Xoffset},
            'Yoffset': {$AMAZINGZOOM_Yoffset},
            'fadeIn': {$AMAZINGZOOM_fadeIn},
            'fadeTrans': {$AMAZINGZOOM_fadeTrans},
            'fadeOut': {$AMAZINGZOOM_fadeOut},
            'smoothZoomMove': {$AMAZINGZOOM_smoothZoomMove},
            'smoothLensMove': {$AMAZINGZOOM_smoothLensMove},
            'smoothScale': {$AMAZINGZOOM_smoothScale},
            'defaultScale': {$AMAZINGZOOM_defaultScale},
            'scroll': {$AMAZINGZOOM_scroll},
            'tint': '{$AMAZINGZOOM_tint}',
            'tintOpacity': {$AMAZINGZOOM_tintOpacity},
            'lens': {$AMAZINGZOOM_lens},
            'lensOpacity': {$AMAZINGZOOM_lensOpacity},
            'lensShape': '{$AMAZINGZOOM_lensShape}',
            'lensCollision': {$AMAZINGZOOM_lensCollision},
            'lensReverse': {$AMAZINGZOOM_lensReverse},
            'openOnSmall': {$AMAZINGZOOM_openOnSmall},
            'zoomWidth': '{$AMAZINGZOOM_zoomWidth}',
            'zoomHeight': '{$AMAZINGZOOM_zoomHeight}',
            'sourceClass': '{$AMAZINGZOOM_sourceClass}',
            'loadingClass': '{$AMAZINGZOOM_loadingClass}',
            'lensClass': '{$AMAZINGZOOM_lensClass}',
            'zoomClass': '{$AMAZINGZOOM_zoomClass}',
            'activeClass': '{$AMAZINGZOOM_activeClass}',
            'hover': {$AMAZINGZOOM_hover},
            'adaptive': {$AMAZINGZOOM_adaptive},
            'adaptiveReverse': {$AMAZINGZOOM_adaptiveReverse},
            'title': {$AMAZINGZOOM_title},
            'titleClass': '{$AMAZINGZOOM_titleClass}',
            'bg': {$AMAZINGZOOM_bg}
        });
    });
</script>
