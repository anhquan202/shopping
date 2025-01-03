import $ from 'jquery';

function validatePhone() {
  const userPhone = $('#user_phone');
  const regexPhone = /^0\d{9,10}$/;
  const errorElement = userPhone.siblings('.error-phone');

  if (userPhone.val().length === 0) {
    errorElement.text('Phone Number is required');
    return false;
  } else if (!regexPhone.test(userPhone.val())) {
    errorElement.text('Phone Number Format is incorrect');
    return false
  } else {
    errorElement.text('');
    return true;
  }
}
export { validatePhone };