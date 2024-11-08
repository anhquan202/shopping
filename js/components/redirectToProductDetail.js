import $ from 'jquery';

function redirectToProductDetail() {
  $('.product-item').on('click', function () {
    var productId = $(this).data('product-id');
    window.location.href = 'productDetail?product_id=' + productId;
  })
}

export default redirectToProductDetail;