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

$(document).ready(function () {

  var swipe = '<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">\
    <div class="pswp__bg"></div>\
    <div class="pswp__scroll-wrap">\
      <div class="pswp__container">\
        <div class="pswp__item"></div>\
        <div class="pswp__item"></div>\
        <div class="pswp__item"></div>\
      </div>\
      <div class="pswp__ui pswp__ui--hidden">\
        <div class="pswp__top-bar">\
          <div class="pswp__counter"></div>\
          <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>\
          <button class="pswp__button pswp__button--share" title="Share"></button>\
          <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>\
          <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>\
          <div class="pswp__preloader">\
            <div class="pswp__preloader__icn">\
              <div class="pswp__preloader__cut">\
                <div class="pswp__preloader__donut"></div>\
              </div>\
            </div>\
          </div>\
        </div>\
        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">\
          <div class="pswp__share-tooltip"></div>\
        </div>\
        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">\
        </button>\
        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">\
        </button>\
        <div class="pswp__caption">\
          <div class="pswp__caption__center"></div>\
        </div>\
      </div>\
    </div>\
  </div>';

  $('body').append(swipe);
});

