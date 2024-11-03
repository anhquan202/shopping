import $ from 'jquery';

const password = $('#password');
const repeatPassword = $('#repeat-password');
const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;

function checkPassword() {
  return validatePassword() && validateRepeatPassword();
}
function validatePassword() {
  const errorElementPassword = password.siblings('.error-password');
  if (password.val().length === 0) {
    errorElementPassword.text('Password is required');
    return false;
  } else if (!regexPassword.test(password.val())) {
    errorElementPassword.text('Password must be at least 6 characters, include both letters and numbers');
    return false;
  } else {
    errorElementPassword.text('');
    return true;
  }
}

function validateRepeatPassword() {
  const errorElementRepeatPassword = repeatPassword.siblings('.error-repeat-password');
  if (repeatPassword.val().length === 0) {
    errorElementRepeatPassword.text('Password is required');
    return false;
  } else if (repeatPassword.val() !== password.val()) {
    errorElementRepeatPassword.text('Passwords do not match');
    return false;
  } else {
    errorElementRepeatPassword.text('');
    return true;
  }
}
export { checkPassword, validatePassword, validateRepeatPassword };