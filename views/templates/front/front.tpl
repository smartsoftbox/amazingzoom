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
<link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/xzoom.css" rel="stylesheet" type="text/css"/>
<script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/hammer.min.js'></script>

<style>
  {foreach $amazingzooms as $az}
  {$az.css nofilter}
  {/foreach}
</style>


<script type="text/javascript">

    $(document).ready(function () {
        //HammerJS v2.0.8
        var isTouchSupported = 'ontouchstart' in window;

        {foreach $amazingzooms as $az}

        {$az.js nofilter}
        // document is loaded and DOM is ready
        $("{$az.css_selector|escape:'htmlall':'UTF-8'}").each(function () {
            $(this).attr("xoriginal", $(this).attr("src").replace("-home_default", "{$az.image_type}")
                .replace("-large_default", "{$az.image_type}").replace("-small_default", "{$az.image_type}"));
        });
        /* calling script */
        $('{$az.css_selector}').each(function () {
            var xzoom = $(this).xzoom({
                'position': '{$az.position}',
                'mposition': '{$az.mposition}',
                'rootOutput': {$az.rootOutput},
                'Xoffset': {$az.Xoffset},
                'Yoffset': {$az.Yoffset},
                'fadeIn': {$az.fadeIn},
                'fadeTrans': {$az.fadeTrans},
                'fadeOut': {$az.fadeOut},
                'smoothZoomMove': {$az.smoothZoomMove},
                'smoothLensMove': {$az.smoothLensMove},
                'smoothScale': {$az.smoothScale},
                'defaultScale': {$az.defaultScale},
                'scroll': {$az.scroll},
                'tint': '{$az.tint}',
                'tintOpacity': {$az.tintOpacity},
                'lens': '{$az.lens}',
                'lensOpacity': {$az.lensOpacity},
                'lensShape': '{$az.lensShape}',
                'lensCollision': {$az.lensCollision},
                'lensReverse': {$az.lensReverse},
                'openOnSmall': {$az.openOnSmall},
                'zoomWidth': '{$az.zoomWidth}',
                'zoomHeight': '{$az.zoomHeight}',
                'adaptive': {$az.adaptive},
                'adaptiveReverse': {$az.adaptiveReverse},
                'title': {$az.title},
                'bg': {$az.bg}
            });


            if (isTouchSupported) {
                xzoom.eventunbind();
                var mc1 = new Hammer($(this)[0]);

                mc1.on("tap", function (event) {
                    event.pageX = event.srcEvent.pageX;
                    event.pageY = event.srcEvent.pageY;

                    xzoom.eventclick = function (element) {
                        element.css('touch-action', 'pan-x');
                    };

                    xzoom.eventmove = function (element) {
                        var mc2 = new Hammer(element[0]);

                        mc2.get('pan').set({
                            direction: Hammer.DIRECTION_ALL,
                        });

                        mc2.on('pan', function (event) {
                            event.pageX = event.srcEvent.pageX;
                            event.pageY = event.srcEvent.pageY;
                            xzoom.movezoom(event);
                            // event.srcEvent.preventDefault();
                        });
                    };

                    xzoom.eventleave = function (element) {
                        var mc3 = new Hammer(element[0]);
                        mc3.on('tap', function (event) {
                            xzoom.closezoom();
                        });
                    };
                    xzoom.openzoom(event);
                });
            } else {
                $(this).bind('click', function () {
                    xzoom.closezoom();
                });
            }
        });
        {/foreach}

    });
</script>
