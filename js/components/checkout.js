import $ from 'jquery';

let fullName, phoneReceiver, address, paymentMethod;
function purchase() {
  $('.btn-purchase').on('click', async function (e) {
    e.preventDefault();
    saveReceiverUserInfo();

    if (paymentMethod === 'atm') {
      checkoutByVNPay();
    } else if (paymentMethod === 'delivered') {
      if (confirm('You chose cash on delivery. Would you like to confirm this?')) {
        window.location.href = 'thanks';
      }
    }
  })
}

//send receiver infomation (full_name, user_phone, address)
function saveReceiverUserInfo() {
  paymentMethod = $("input[name='payment_method']:checked").val();
  fullName = $('.identity #receiver-name').text();
  phoneReceiver = $('.identity #receiver-phone').text();
  address = $('.identity #receiver-address').text();
  localStorage.setItem('receiverInfo', JSON.stringify({ fullName, phoneReceiver, address, paymentMethod }));
}

function checkoutByVNPay() {
  let amount = $('.order-totals').find('.amount').text();
  amount = parseInt(amount.split(',').join(''));

  $.ajax({
    method: "POST",
    url: "checkoutByVNPay",
    data: {
      amount: amount,
      bankcode: '',
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
export { purchase };