import $ from 'jquery';
import { validatePhone } from '../components/validate/validatePhone';
import { validateFullName } from '../components/validate/validateFullname';
import { validatePassword } from '../components/validate/validatePassword';
import { validateRepeatPassword } from '../components/validate/validatePassword';
function register() {
  validation();

  //call api register
  $('.btn-signup').on('click', function (e) {
    e.preventDefault();
    let formData = new FormData($('#signup-form')[0]);
    $.ajax({
      method: 'post',
      url: 'register',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success === 201) {
          const token = response.token;
          localStorage.setItem('authToken', token);
          alert(response.message);
          window.location.href = '/shopping';
        } else {
          console.log('unsuccess');
          displayErrorFromApi(response.errors);
        }
      },
      error: function (error) {
        console.log(error);
      }
    });
  })
}

function displayErrorFromApi(errors) {
  $('#full_name').siblings('.error-fullname').text(errors['full_name'] ?? '');
  $('#user_phone').siblings('.error-phone').text(errors['user_phone'] ?? '');
  $('#password').siblings('.error-password').text(errors['password'] ?? '');
  $('#repeat-password').siblings('.error-repeat-password').text(errors['repeat_password'] ?? '');
}

function validation() {
  $('#full_name').on('input blur', function () {
    validateFullName();
  })

  $('#user_phone').on('input blur', function () {
    validatePhone();
  })

  $('#password').on('input blur', function () {
    validatePassword();
  })

  $('#repeat-password').on('input blur', function () {
    validateRepeatPassword();
  })
}
export default register;