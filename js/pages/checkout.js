import $ from 'jquery';
import getAddressData from "../components/address/handleProvinceData";
import { showInfoInCheckPage } from '../components/userInfo/handleInCheckPage';
import { modal } from "../components/modal";
import { showInfoInCheckPage } from '../components/userInfo/handleInCheckPage';
import { purchase } from '../components/checkout';
export default function checkout() {
  showInfoInCheckPage();
  getAddressData();
  modal();
  purchase();
}
