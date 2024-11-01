import $ from 'jquery';
function validationAuth() {
  checkFullName();
  checkPhone();
  checkPassword();
}

function checkFullName() {
  var fullName = $('#full_name');
  var regexName = /^[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸỳỵỷỹ\s]{2,}$/;

  //error message
  var nameEmpty = 'Name is required';
  var nameFormat = 'Name Format is incorrect';

  fullName.on('blur', function () {
    if (fullName.val().length === 0) {
      $(this).siblings('.error-fullname').text(nameEmpty);
    } else if (!regexName.test(fullName.val())) {
      $(this).siblings('.error-fullname').text(nameFormat);
    } else {
      $(this).siblings('.error-fullname').text('');
    }
  })
}
function checkPhone() {
  var userPhone = $('#user_phone');
  var regexPhone = /^0\d{9,10}$/;

  //error message
  var phoneEmpty = 'Phone Number is required';
  var phoneFormat = 'Phone Number Format is incorrect';

  userPhone.on('blur', function () {
    if (userPhone.val().length === 0) {
      $(this).siblings('.error-phone').text(phoneEmpty);
    } else if (!regexPhone.test(userPhone.val())) {
      $(this).siblings('.error-phone').text(phoneFormat);
    } else {
      $(this).siblings('.error-phone').text('');
    }
  })
}

function checkPassword() {
  var password = $('#password');
  var repeatPassword = $('#repeat-password');

  var regexPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;

  //error message
  var passwordEmpty = 'Password is required';
  var passwordFormat = 'Password must be at least 6 characters, include both letters and numbers';
  var passwordMatch = 'Passwords do not match';

  password.on('blur', function () {
    if (password.val().length === 0) {
      $(this).siblings('.error-password').text(passwordEmpty);
    } else if (!regexPassword.test(password.val())) {
      $(this).siblings('.error-password').text(passwordFormat);
    } else {
      $(this).siblings('.error-password').text('');
    }
  })
  $('#repeat-password').on('blur', function () {
    if (repeatPassword.val().length === 0) {
      $(this).siblings('.error-repeat-password').text(passwordEmpty);
    } else if (repeatPassword.val() !== password.val()) {
      $(this).siblings('.error-repeat-password').text(passwordMatch);
    } else {
      $(this).siblings('.error-password').text('');
    }
  })
}
export default validationAuth;