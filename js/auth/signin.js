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

// Complete Profile User After Oauth
function completeProfileUserAfterOauth() {
  validation();
  $('.btn-save').on('click', function (e) {
    e.preventDefault();
    const fullName = $('#full_name').val();
    const userPhone = $('#user_phone').val();
    const address = $('#address').val();
    $('#user_email').prop('disabled', true);
    $.ajax({
      method: 'post',
      url: 'complete-profile-user-after-oauth',
      data: {
        full_name: fullName,
        user_phone: userPhone,
        address: address
      },
      success: function (response) {
        if (response.status === 201) {
          alert(response.message);
          window.location.href = '/shopping';
        } else {
          console.log(response.error);
        }
      },
      error: function (xhr) {
        throw new Error(xhr.responseText())
      }
    })
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
export { signin, completeProfileUserAfterOauth };