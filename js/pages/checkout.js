import $ from 'jquery';
import { showInfoInCheckPage } from "../components/handleUserInfo";
import getAddressData from "../components/address/handleProvinceData";
import { modal } from "../components/modal";
import { validateFullName } from '../components/validate/validateFullname';
import { validatePhone } from '../components/validate/validatePhone';

export default function checkout() {
  showInfoInCheckPage();
  getAddressData();
  modal();
  validatePhone();
  $('.btn-purchase').on('click', function (e) {
    e.preventDefault();
    const cartId = $(this).data('cart-id');
    let paymentMethod = $("input[name='payment-method']:checked").val();

    if (paymentMethod === 'vnpay') {
      checkoutByVNPay(cartId);
    } else {
      alert("Please select a payment method.");
    }
  })
}
function checkoutByVNPay(cartId) {
  let amount = $('.order-totals').find('.amount').text();
  amount = parseInt(amount.split(',').join(''));

  $.ajax({
    method: "POST",
    url: "checkoutByVNPay",
    data: {
      amount: amount,
      bankcode: '',
      cart_id: cartId,
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);

      if (response.code === "00") {
        window.location.href = response.data;
      } else {
        console.log("Error: " + response);
      }
    },
    error: function () {
      console.log("An error occurred while processing the payment.");
    }
  })

}