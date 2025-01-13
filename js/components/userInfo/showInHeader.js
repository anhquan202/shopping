import $ from 'jquery';
import { getUserInfoDetail } from './getUserInfoFromApi';

async function showUserInfoInHeader() {
  try {
    const userInfo = await getUserInfoDetail();

    const fullName = userInfo.fullName;
    const lastName = fullName.split(' ').pop();

    $('.user-info').css('display', 'block')
    $('.user-info').find('.user-name').text(lastName);
    if (userInfo.avatar) {
      $('#user-icon').attr('src', userInfo.avatar);
    }
  } catch (xhr) {
    console.log(xhr);
  }
}
export default showUserInfoInHeader;