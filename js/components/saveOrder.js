import $ from 'jquery';
function saveOrder() {
  let receiverInfo = localStorage.getItem('receiverInfo');
  receiverInfo = JSON.parse(receiverInfo);
  $.ajax({
    method: 'POST',
    url: 'saveOrder',
    data: {
      receiver_name: receiverInfo.fullName,
      receiver_phone: receiverInfo.phoneReceiver,
      receiver_address: receiverInfo.address,
      payment_method: receiverInfo.paymentMethod
    },
  }).done(function (data) {
    if (data.status === 200) {
      localStorage.removeItem('receiverInfo');
      console.log(data.message);
    }
  });
}
export default saveOrder;