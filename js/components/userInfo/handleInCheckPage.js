import $ from 'jquery';
import { getUserInfoDetail } from './getUserInfoFromApi';
import { validatePhone } from '../validate/validatePhone';
import { validateFullName } from '../validate/validateFullName';
let receiverName = '', receiverPhone = '', receiverAddress = '';
function handleInCheckPage() {
  showInfoInCheckPage();

  changeUserInfo();
}
async function showInfoInCheckPage() {
  try {
    const userInfo = await getUserInfoDetail();
    const fullName = capitalizeFirstLetter(userInfo.fullName);
    receiverName = fullName;
    receiverPhone = userInfo.userPhone;
    receiverAddress = userInfo.info.address;

    $('.form-group').find('#full_name').val(receiverName);
    $('.form-group').find('#user_phone').val(receiverPhone);
    $('.form-group').find('#address').val(receiverAddress);
    updateUI();
  } catch (error) {
    console.log(error);
  }
}

function changeUserInfo() {
  validate();
  $('.btn-save').on('click', function () {
    receiverName = $('#full_name').val();
    receiverPhone = $('#user_phone').val();
    receiverAddress = $('#address').val();
    if (validateFullName() && validatePhone()) {
      $('#modal-overlay').css('display', 'none');
      updateUI();
    }
    // $('#modal-overlay').css('display', 'none');
  });
}
function validate() {
  $('#full_name').on('input blur', function () {
    validateFullName();
  });
  $('#user_phone').on('input blur', function () {
    validatePhone();
  });
}
function updateUI() {
  $('#receiver-name').text(receiverName);
  $('#receiver-phone').text(receiverPhone);
  $('#receiver-address').text(receiverAddress);
}

function capitalizeFirstLetter(str) {
  if (!str) {
    return
  } else {
    return str.split(' ')
      .map(function (word) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
      })
      .join(' ');
  }
}
export { handleInCheckPage };