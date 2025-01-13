import $ from 'jquery';
import { getUserInfoDetail } from './getUserInfoFromApi';

async function showInfoInCheckPage() {
  try {
    const userInfo = await getUserInfoDetail();
    const fullName = capitalizeFirstLetter(userInfo.fullName)
    $('#receiver-name').text(fullName);
    $('#receiver-phone').text(userInfo.userPhone);
    $('#receiver-address').text(userInfo.info.address);

    $('.form-group').find('#full_name').val(fullName);
    $('.form-group').find('#user_phone').val(userInfo.userPhone);
    $('.form-group').find('#address').val(userInfo.info.address);
  } catch (error) {
    console.log(error);
  }
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
export { showInfoInCheckPage };