import { checkPhone } from "./validatePhone";
import { checkFullName } from "./validateFullname";
import { checkPassword } from "./validatePassword";
function checkAuth() {
  let isPhoneValid = checkPhone();
  let isFullName = checkFullName();
  let isPassword = checkPassword();
  return isPhoneValid && isFullName && isPassword;
}
export default checkAuth;