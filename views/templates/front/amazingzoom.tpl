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
{* XZOOM *}

{if $is_zoom_enable}
  <script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/xzoom.js'></script>
  <link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/xzoom.css" rel="stylesheet" type="text/css"/>
  <script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/hammer.min.js'></script>
  <link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/xzoom.css" rel="stylesheet" type="text/css"/>
{/if}

{if $is_swipe_enable}
  {* PHOTOSWAPE *}
  <script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/photoswipe.js'></script>
  <link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/photoswipe.css" rel="stylesheet" type="text/css"/>
  {* PHOTOSWAPE SKIN *}
  <script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/photoswipe-ui-default.min.js'></script>
  <link href="{$this_path|escape:'htmlall':'UTF-8'}views/css/default-skin.css" rel="stylesheet" type="text/css"/a>
{/if}

{if $amazingzooms}
  <style>
    {if $is_17}
      .product-cover .layer {
        display: none;
      }
    {/if}

    {if !$is_17}
      #blockbestsellers .product_img_link img, #homefeatured .product_img_link img,
      #blockspecials .product_img_link img, #blocknewproducts .product_img_link img {
        width: 268px;
        height: 268px;
      }
      #page .product-container .product-image-container {
        padding: 0;
      }
    {/if}
  </style>

  <script type="text/javascript">

      $(document).ready(function () {
          //HammerJS v2.0.8
          {foreach $amazingzooms as $az}

          var az = {$az|json_encode nofilter};
          {* I convert here php array to javascript array withou nofilter it does not work correct *}

          {if $az.is_enable}
            initializeXzoom(az);
            {if $is_17 && $is_product_page}
              $('body').on('DOMNodeInserted', 'div.images-container', function() {
                  initializeXzoom(az);
              });
            {/if}
          {/if}

          {if $az.swipe_is_enable}
            initializeSwipe(az);
            {if $is_17 && $is_product_page}
              $('body').on('DOMNodeInserted', 'div.images-container', function() {
                initializeXzoom(az);
              });
            {/if}
          {/if}

          {/foreach}
      });


    function initializeXzoom(az) {
        var isTouchSupported = 'ontouchstart' in window;

        $(az['css_selector']).each(function() {

            initialize(az);
            /* calling script */
            var xzoom = $(this).xzoom({
                'position': az['position'],
                'mposition': az['mposition'],
                'Xoffset': parseInt(az['Xoffset']),
                'Yoffset': parseInt(az['Yoffset']),
                'fadeIn': az['fadeIn'],
                'fadeOut': az['fadeOut'],
                'defaultScale': az['defaultScale'],
                'scroll': az['scroll'],
                'tint': az['tint'],
                'tintOpacity': az['tintOpacity'],
                'lens': az['lens'],
                'lensOpacity': az['lensOpacity'],
                'lensShape': az['lensShape'],
                'lensCollision': az['lensCollision'],
                'bg': az['bg']
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

            }

        });
    }

    function initializeSwipe(az) {
        initialize(az);
        //Example: Integration with "Magnific Popup" plugin
        $(az['css_selector']).bind('click', function (event) {
            event.preventDefault();

            {if $az.is_enable}
            var xzoom = $(this).data('xzoom');
            xzoom.closezoom();
            {/if}

            var trigger = $(this);
            var $pswp = $('.pswp')[0];
            var gallery;

            {if $az.thumb_selector}
            gallery = $(az['thumb_selector']);
            {else}
            gallery = $(this);
            {/if}

            // console.log(gallery);
            var $index = 0, images = [];
            gallery.each(function (index, value) {
                var image = {
                    src: $(this).attr('xoriginal'),
                    w: az['image_width'],
                    h: az['image_height']
                };
                var src = trigger.attr('xoriginal');
                if (image.src === src) {
                    $index = index;
                }

                images.push(image);
            });
            console.log(images);
            // var src = $(this).attr('src').replace("-large_default", "-home_default");
            // console.log(src);
            // var $index = images.indexOf(src);
            var options = {
                index: $index,
                showHideOpacity: {$az.swipe_showHideOpacity|escape:'html':'UTF-8'},
                showAnimationDuration: {$az.swipe_showAnimationDuration|escape:'html':'UTF-8'},
                hideAnimationDuration: {$az.swipe_hideAnimationDuration|escape:'html':'UTF-8'},
                bgOpacity: {$az.swipe_bgOpacity|escape:'html':'UTF-8'},
                spacing: {$az.swipe_spacing|escape:'html':'UTF-8'},
                allowPanToNext: {$az.swipe_allowPanToNext|escape:'html':'UTF-8'},
                history: false,
                maxSpreadZoom: {$az.swipe_maxSpreadZoom|escape:'html':'UTF-8'},
                loop: {$az.swipe_loop|escape:'html':'UTF-8'},
                pinchToClose: {$az.swipe_pinchToClose|escape:'html':'UTF-8'},
                closeOnScroll: {$az.swipe_closeOnScroll|escape:'html':'UTF-8'},
                closeOnVerticalDrag: {$az.swipe_closeOnVerticalDrag|escape:'html':'UTF-8'},
                arrowKeys: {$az.swipe_arrowKeys|escape:'html':'UTF-8'},
                modal: {$az.swipe_modal|escape:'html':'UTF-8'},
                enableMouseWheel: false ,
                enableKeyboard: false,
                clickToCloseNonZoomable: false
            };

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, images, options);
            lightBox.init();
        });
    }

    function initialize(az) {
        {if $is_17 && $is_product_page}
          $(az['css_selector']).click(function () {
              $(".product-cover").find(".layer").click();
          });
          $(az['thumb_selector']).click(function () {
              $(az['css_selector']).attr("xoriginal", $(this).attr("xoriginal"));
          });
        {/if}

        {if !$is_17 && $is_product_page}
          $(az['thumb_selector']).mouseover(function () {
              $(az['css_selector']).attr("xoriginal", $(this).attr("xoriginal"));
          });
        {/if}
        // document is loaded and DOM is ready
        $(az['css_selector']).each(function () {
            $(this).attr("xoriginal", $(this).attr("src")
                .replace("-home_default", az['image_type'])
                .replace("-large_default",  az['image_type'])
                .replace("-small_default",  az['image_type'])
            );
        });

        {if $az.thumb_selector}
          // document is loaded and DOM is ready
          $(az['thumb_selector']).each(function () {
              $(this).attr("xoriginal", $(this).attr("src")
                  .replace("-home_default", az['image_type'])
                  .replace("-large_default", az['image_type'])
                  .replace("-small_default", az['image_type'])
                  .replace("-cart_default", az['image_type'])
              );
          });
        {/if}
    }

  </script>

    {if $is_swipe_enable}
      {*photoswipe*}
      <script type='text/javascript' src='{$this_path|escape:'htmlall':'UTF-8'}views/js/swipe-html.js'></script>
    {/if}
{/if}


