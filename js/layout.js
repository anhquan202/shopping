import logout from "./auth/logout";
import { updateCartCount } from "./components/cart";
import showUserInfoInHeader from "./components/userInfo/showInHeader";
export default function layout() {
  showUserInfoInHeader();
  updateCartCount();
  logout();
}