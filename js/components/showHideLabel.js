import $ from 'jquery';
function showHideLabel() {
  $('.form-group').each(function () {
    var label = $(this).find('label');
    var input = $(this).find('.input-field');
    var placeholderText = input.attr('placeholder');

    input.on('focus', function () {
      label.addClass('visible');
      input.removeAttr('placeholder');
    })
    input.on('blur', function () {
      if (!input.val()) {
        label.removeClass('visible');
        input.attr('placeholder', placeholderText);
      }
    })
  })
}
export default showHideLabel;