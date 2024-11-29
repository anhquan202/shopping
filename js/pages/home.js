import { showUserInfo } from '../components/getUserInfoFromToken';
import redirectToProductDetail from '../components/redirectToProductDetail';
import automaticSlide from '../components/showSlide';
export default function home() {
  automaticSlide();
  redirectToProductDetail();
  showUserInfo();
}