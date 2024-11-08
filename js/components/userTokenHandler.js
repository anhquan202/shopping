import $ from 'jquery';
import decodeToken from "../jwt/decodeUserToken";
import saveTokenFromGoogle from '../jwt/saveTokenFromOauth';
function getInforUser() {
  saveTokenFromGoogle();
  const infoUser = decodeToken('authToken');
  if (infoUser) {
    const fullName = infoUser.data.full_name;

    const nameParts = fullName.split(" ");
    const lastName = nameParts[nameParts.length - 1];

    $('.user-info').css('display', 'block');
    $('.user-info').find('.user-name').text(lastName);

  }
}
export default getInforUser;