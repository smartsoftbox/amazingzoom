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
  $(document.body).on('click', '#copy_model', function (e) {
    e.preventDefault();
    $('#dsDialog').modal('show');
    $('#dsDialog .amazingzoom-tab.list-group-item.active').removeClass('active');
  });

  //index tabs
  $(document.body).on('click', '#dsDialog .list-group a', function (e) {
    e.preventDefault();
    var id = $(this).attr('id').replace('copy-', '');
    var id_to = $('.amazingzoom-tab.list-group-item.active').attr('id');

    $.ajax({
      type: 'POST',
      url: ajax_url + '&action=copyFrom',
      dataType: 'json',
      cache: false,
      data: {id: id, id_to: id_to},
      success: function (data) {
        $('#dsDialog').modal('hide');
        displayTabContent(id, data.form, data.message);
      }
    });
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
          displayTabContent(id, data);
        }
      });
    }
  });

  //index tabs
  $(document.body).on('click', 'button[name="submitAmazingzoomModule"]', function (e) {
    e.preventDefault();
    var button = $(this);
    button.html(function (i, t) {
      return t.replace('Save', 'Please wait ...')
    });

    var form = $(this).closest('form');

    $.ajax({
      type: 'POST',
      url: ajax_url + '&action=saveConfigForm',
      data: form.serialize(),
      cache: false,
      success: function (data) {
        displayMessage(data);

        button.html(function (i, t) {
          return t.replace('Please wait ...', 'Save')
        });
      }
    });
  });

  $(document.body).on('click', 'input[id^=swipe_is_enable], input[id^=is_enable], input[id^=use_default]', function (e, data) {
    var url = ajax_url + '&action=saveConfigForm';
    var form = $(this).closest('form');
    var id = form.find('#id').val();
    var id_input = $(this).attr('id').replace("_on", "").replace("_off", "");
    var index = id_input.lastIndexOf("_");
    var id_button = $(this).attr('id').substring(0, index);

    $.post(url, form.serialize(), function (data) {
      displayMessage(data);
      $('a.amazingzoom-tab[id="' + id + '"]').find('i.' + id_button).toggleClass('active');
    });
  });

  $(document.body).on('click', '#load_default', function (e, data) {
    e.preventDefault();
    showLoader();

    var id = $(this).closest('form').find('input[name="id"]').val();
    var url = ajax_url + '&ajax=1&id=' + id + '&action=loadDefaultSettings';

    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      cache: false,
      success: function (data) {
        displayTabContent(id, data.form, data.message);
        ;
        hideLoader();
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

function createEditor(name, mode) {
  var textarea = $("textarea#" + name);
  var editDiv = $('<div id="div-' + name + '">').insertBefore(textarea);
  textarea.css('display', 'none');

  var editor = ace.edit(editDiv[0], {
    mode: "ace/mode/" + mode,
    selectionStyle: "text"
  });
  editor.getSession().setValue(textarea.val());
  editor.setTheme("ace/theme/tomorrow");

  // copy back to textarea on form submit...
  editor.getSession().on('change', function () {
    textarea.val(editor.getSession().getValue());
  });
}

function showLoader() {
  $('#right-column div.tab-content').hide();
  $('#ajax-loader').css('display', 'flex');
}

function hideLoader() {
  $('#ajax-loader').hide();
  $('#right-column div.tab-content').fadeIn();
}

function displaySwitchInline() {
  $('input[name^="is_enable"]').closest('.form-group').css({'width': '50%', 'display': 'inline-block'});
  $('input[name^="swipe_is_enable"]').closest('.form-group').css({'width': '50%', 'display': 'inline-block'});
}

function convertRangeToSlider()
{
  const sliders = document.querySelectorAll('input[type="range"]');
  sliders.forEach(function (slider) {
    rangeSlider.create(slider, {
      root: document,
      vertical: false,
      borderRadius: 3,
      onInit: function () {
      },
      onSlide: function (position, value) {
        $(slider).closest('.col-lg-9').find('.value-range-slider').val(position);
      }
    });
  });
}

function displayTabContent(id, form, message = null)
{
  $('div[alt="model-' + id + '"]').html(form);
  $('input[type="color"]').mColorPicker();
  unique_field_id = 'div[alt="' + id + '"]'; // for tabs

  createTabs();
  displaySwitchInline();
  convertRangeToSlider();
  hideLoader();
  createEditor('js_' + id, 'javascript');
  createEditor('css_' + id, 'css');

  if(message) {
    displayMessage(message);
  }
}

function  displayMessage(message) {
  $('.module_error').remove();
  $('.module_confirmation').parent().remove();
  $("#amazingZoom").before(message).fadeIn();
  setTimeout(function () {
    $('.alert').fadeOut(500, function () {
      $(this).remove();
    });
    ;
  }, 5000);
}

function createTabs() {
  if (typeof helper_tabs != 'undefined' && typeof unique_field_id != 'undefined') {
    $.each(helper_tabs, function (index) {
      var form = 'module_form_1';
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
