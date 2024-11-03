import $ from 'jquery';

const fullName = $('#full_name');
function checkFullName() {
  return validateFullName();
}

function validateFullName() {
  const regexName = /^[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸỳỵỷỹ\s]{2,}$/;
  const errorElementFullName = fullName.siblings('.error-fullname');

  if (fullName.val().length === 0) {
    errorElementFullName.text('Name is required');
    return false;
  } else if (!regexName.test(fullName.val())) {
    errorElementFullName.text('Name Format is incorrect');
    return false;
  } else {
    errorElementFullName.text('');
    return true;
  }
}

export { checkFullName, validateFullName };