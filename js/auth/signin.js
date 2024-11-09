import $ from 'jquery';
import { validatePhone } from '../components/validate/validatePhone';
import { validatePassword } from '../components/validate/validatePassword';
function signin() {
  validation();

  //call api signin
  $('.btn-login').on('click', function (e) {
    e.preventDefault();
    let formData = new FormData($('#login-form')[0]);
    $.ajax({
      method: 'post',
      url: 'signin',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.status === 201) {
          alert(response.message);
          window.location.href = '/shopping';
        } else {
          if (response.user_phone) {
            $('.error-phone').text(response.user_phone);
          }
          if (response.password) {
            $('.error-password').text(response.password);
          }
          if (response.message) {
            $('.error-login').text(response.message);
            setTimeout(function () {
              $('.error-login').text('');
            }, 3000);
          }
        }
      },
      error: function (error) {
        console.log(error);
      }
    });
  })
}

function validation() {
  $('#user_phone').on('input blur', function () {
    validatePhone();
  })

  $('#password').on('input blur', function () {
    validatePassword();
  })
}
export default signin;