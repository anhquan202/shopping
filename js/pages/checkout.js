import getAddressData from "../components/address/handleProvinceData";
import { handleInCheckPage } from '../components/userInfo/handleInCheckPage';
import { modal } from "../components/modal";
import { purchase } from '../components/checkout';
export default function checkout() {
  handleInCheckPage();
  getAddressData();
  modal();
  purchase();
}
