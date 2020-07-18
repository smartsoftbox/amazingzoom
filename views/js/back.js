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
  $(document.body).on('click', '.inline-radio', function () {
    $(this).parent().find('.inline-radio').removeClass('active');
    $(this).addClass('active');
    $(this).find('input[type="radio"]').attr('checked', 'checked');
  });

  //index tabs
  $('#amazingzooms a.amazingzoom-tab ').on('click', function () {
    var id = $(this).attr('id');

    if ($('div[alt="model-' + id + '"]').is(':empty')) {
      showLoader();
      $.ajax({
        type: 'GET',
        url: ajax_url + '&id=' + id,
        data: {
          ajax: 1,
          action: 'getConfigForm',
          id_page: id
        },
        success: function (data) {
          $('div[alt="model-' + id + '"]').html(data);
          // setupAllTabs();
          $('input[type="color"]').mColorPicker();
          unique_field_id = 'div[alt="' + id + '"]';
          createTabs(id);
          displaySwitchInline();
          convertRangeToSlider();
          hideLoader();
        }
      });
    }
  });

  //index tabs
  $(document.body).on('click', 'button[name="submitAmazingzoomModule"]', function (e) {
    e.preventDefault();
    var button = $(this);
    button.html(function(i,t){
      return t.replace('Save', 'Please wait ...')
    });

    var form = $(this).closest('form');

    $.ajax({
      type: 'POST',
      url: ajax_url + '&action=saveConfigForm',
      data: form.serialize(),
      cache: false,
      success: function (data) {
        $('.module_errors').remove();
        $('.module_confirmation').parent().remove();
        $("#amazingZoom").before(data);

        button.html(function(i,t){
          return t.replace('Please wait ...', 'Save')
        });
      }
    });
  });

  $(document.body).on('click', 'input[id^=is_enable], input[id^=is_enable]', function (e, data) {
    var url =  ajax_url + '&action=saveConfigForm';
    var form = $(this).closest('form');
    var id = form.find('#id').val();
    $.post( url, form.serialize(), function( data ) {
      $('.module_errors').fadeOut().remove();
      $('.module_confirmation').parent().fadeOut().remove();
      $("#amazingZoom").before(data);
      $('a.amazingzoom-tab[id="' + id + '"]').find('i.icon-circle-blank').toggleClass('active');
    });
  });

  $(document.body).on('click', 'input[id^=use_default], input[id^=use_default]', function (e, data) {
    var url =  ajax_url + '&action=saveConfigForm';
    var form = $(this).closest('form');
    var id = form.find('#id').val();
    $.post( url, form.serialize(), function( data ) {
      $('.module_errors').fadeOut().remove();
      $('.module_confirmation').parent().fadeOut().remove();
      $("#amazingZoom").before(data);
      $('a.amazingzoom-tab[id="' + id + '"]').find('i.icon-gear').toggleClass('active');
    });
  });

  $(document.body).on('click', '#load_default', function (e, data) {
    e.preventDefault();
    var button = $(this);
    button.html(function(i,t){
      return t.replace('Save', 'Please wait ...')
    });

    var id = $(this).closest('form').find('input[name="id"]').val();
    var url =  ajax_url + '&ajax=1&id=' + id + '&action=loadDefaultSettings';

    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      cache: false,
      success: function (data) {
        $('div[alt="model-' + id + '"]').html(data.form);
        // setupAllTabs();
        $('input[type="color"]').mColorPicker();
        unique_field_id = 'div[alt="' + id + '"]';
        createTabs();
        displaySwitchInline();
        convertRangeToSlider();
        hideLoader();

        $('.module_errors').remove();
        $('.module_confirmation').parent().remove();
        $("#amazingZoom").before(data.message);
        setTimeout(function(){
          $('.alert').fadeOut(500, function() { $(this).remove(); });;
        }, 5000);

        button.html(function(i,t){
          return t.replace('Please wait ...', 'Save')
        });
      }
    });
  });

  $('#amazingzooms .list-group-item').click(function () {
    var id = $(this).attr('id');
    $('.list-group-item').removeClass('active');
    $(this).addClass('active');

    $('.tab-content.list-group').addClass('hide');
    $('.tab-content[alt=' + id + ']').removeClass('hide');

    var current_tab_id = $('div.list-group a.list-group-item.active').attr('id');
    $.cookie('current_tab_id', current_tab_id);

    return false;
  });

  $('#right-column').css('min-height', $('#amazingzooms').height());

  if ($.cookie('current_tab_id')) {
    var current_tab_id = 'a#' + $.cookie('current_tab_id');
    $('div.list-group a.list-group-item').removeClass('active');
    $(current_tab_id).click();
  } else {
    $('div.list-group a:first').click();
  }
});

function showLoader() {
  $( '#right-column div.tab-content' ).hide();
  $( '#ajax-loader' ).css( 'display', 'flex' );
}

function hideLoader() {
  $( '#ajax-loader' ).hide();
  $( '#right-column div.tab-content' ).fadeIn();
}

function displaySwitchInline() {
  $( 'input[name^="is_enable"]' ).closest( '.form-group' ).css({'width': '50%', 'display': 'inline-block'});
  $( 'input[name^="use_default"]' ).closest( '.form-group' ).css({'width': '50%', 'display': 'inline-block'});
}

function convertRangeToSlider() {
  // Initialize a new plugin instance for one element or NodeList of elements.
  const sliders = document.querySelectorAll('input[type="range"]');
  sliders.forEach(function (slider) {
    rangeSlider.create(slider, {
      // polyfill: true,     // Boolean, if true, custom markup will be created
      root: document,
      vertical: false,    // Boolean, if true slider will be displayed in vertical orientation
      borderRadius: 3,   // Number, if you're using buffer + border-radius in css
      onInit: function () {
      },
      onSlide: function (position, value) {
        $(slider).closest('.col-lg-9').find('.value-range-slider').val(position);
      }
    });
  });
}

function createTabs(id) {
  if (typeof helper_tabs != 'undefined' && typeof unique_field_id != 'undefined') {
    $.each(helper_tabs, function (index) {
      var form = 'module_form';
      if(parseInt(id) !== 5) {
        form = 'module_form_1';
      }
      $(unique_field_id + ' #' + form + ' .form-wrapper').prepend('<div class="tab-content panel" />');
      $(unique_field_id + ' #' + form + ' .form-wrapper').prepend('<ul class="nav nav-tabs" />');
      $.each(helper_tabs[index], function (key, value) {
        // Move every form-group into the correct .tab-content > .tab-pane
        $(unique_field_id + ' #' + form + ' .tab-content').append('<div id="' + key + '" class="tab-pane" />');
        var elements = $(unique_field_id + ' #' + form).find("[data-tab-id='" + key + "']");
        $(elements).appendTo('#' + key);
        // Add the item to the .nav-tabs
        if (elements.length != 0)
          $(unique_field_id + ' #' + form + ' .nav-tabs').append('<li><a href="#' + key + '" data-toggle="tab">' + value + '</a></li>');
      });
      // Activate the first tab
      $(unique_field_id + ' #' + form + ' .tab-content div').first().addClass('active');
      $(unique_field_id + ' #' + form + ' .nav-tabs li').first().addClass('active');
    });
  }
}
