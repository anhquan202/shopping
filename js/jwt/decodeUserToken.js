import { jwtDecode } from "jwt-decode";
function decodeUserToken(key) {
  const token = localStorage.getItem(key);
  const decoded = jwtDecode(token);
  return decoded;
}
export default decodeUserToken;