/**
 *  @author Marcin Kubiak
 *  @copyright  Smart Soft
 *  @license    Commercial license
 *  International Registered Trademark & Property of Smart Soft
 */

jQuery(function ($) {

  $('body').on('click', '.list-group .list-group-item', function () {
    $(this).toggleClass('active');
  });



  $(document.body).on('click', '.list-arrows a', function (e) {
    var $button = $(this), actives = '';

    if ($button.hasClass('move-left')) {
      // get visible li active (selected) but not hidden by filters (filters_hide)
      actives = $('.list-right ul.list-group li.active');
      actives.clone().appendTo('.list-left ul.list-group'); //clone
      actives.remove();
      selector = $('.list-left .selector');

      $('.list-left ul li.active').removeClass('active');
      if (selector.hasClass('selected')) {
        // replace icon from i (select all buttton)
        selector.children('i').removeClass('icon-check-square-o').addClass('icon-check-empty');
        selector.removeClass('selected'); // uncheck a element (select all button)
      }
    } else if ($button.hasClass('move-right')) {
      // get visible li active (selected) but not hidden by filters (filters_hide)
      actives = $('.list-left ul.list-group li.active');
      actives.clone().appendTo('.list-right ul.list-group'); //clone
      actives.remove();
      selector = $('.list-right .selector');

      $('.list-right ul li.active').removeClass('active');
      if (selector.hasClass('selected')) {
        // replace icon from i (select all buttton)
        selector.children('i').removeClass('icon-check-square-o').addClass('icon-check-empty');
        selector.removeClass('selected'); // uncheck a element (select all button)
      }
    }

    addSelectedValue();

    return false;
  });

  addSelectedValue(); // serialize on start field selected

  // version 1.7
  $('.list-right ul.list-group').on('change', 'input', function (e) {
    addSelectedValue();
  });

  $('.list-right ul.list-group').on('click', 'input', function (event) {
    event.stopPropagation();
  });

  // version 1.6
  // $('.list-right ul.list-group li input').live('change', function (e) {
  //   addSlectedValue();
  // });
  //
  // $('.list-right ul.list-group li input').live('click', function (event) {
  //   $(this).parent().removeClass('active');
  // });


  $(document.body).on('click', '.dual-list .selector', function (e) {
      var $checkBox = $(this);
      if (!$checkBox.hasClass('selected')) {
        $checkBox.addClass('selected').closest('.well').find('ul.list-group li:not(.active)').addClass('active');
        $checkBox.children('i').removeClass('icon-check-empty').addClass('icon-check-square-o');
      } else {
        $checkBox.removeClass('selected').closest('.well').find('ul.list-group li.active').removeClass('active');
        $checkBox.children('i').removeClass('icon-check-square-o').addClass('icon-check-empty');
      }
      return false;
  });
  $(document.body).on('keyup', '.list-left input[name="SearchDualList"]', function (e) {
    var code = e.keyCode || e.which;
    if (code == '9') return;
    if (code == '27') $(this).val(null);
    var $rows = $(this).closest('.dual-list').find('.list-group li:not(.filters_hide)');
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    $rows.show().filter(function () {
      var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
      return !~text.indexOf(val);
    }).hide();
  });

  $(document.body).on('keyup', '.list-right input[name="SearchDualList"]', function (e) {
    var code = e.keyCode || e.which;
    if (code == '9') return;
    if (code == '27') $(this).val(null);
    var $rows = $(this).closest('.dual-list').find('.list-group li:not(.filters_hide)');
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    $rows.show().filter(function () {
      var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
      return !~text.indexOf(val);
    }).hide();
  });
});

function addSelectedValue() {
  // create hidden field with all ids from right column and store as comma sepparator
  var all_ids = [];
  $('.list-right ul.list-group li').each(function () {
    var id = $(this).attr("id").replace('option-', '');
    all_ids.push(id);
  });
  // var all_ids_stringify = JSON.stringify(all_ids);
  $("input#controller").val(all_ids.join(','));
}
