import $ from 'jquery';
import { validateFullName } from '../components/validate/validateFullName';
import { validatePhone } from '../components/validate/validatePhone';
import showHideLabel from '../components/showHideLabel';
import { completeProfileUserAfterOauth } from '../auth/signin';
import getAddressData from '../components/address/handleProvinceData';
export default function completeProfile() {
  validation();
  showHideLabel();
  getAddressData();
  completeProfileUserAfterOauth();
}
function validation() {
  $('#user_phone').on('input blur', function () {
    validatePhone();
  })

  $('#full_name').on('input blur', function () {
    validateFullName();
  })
}
