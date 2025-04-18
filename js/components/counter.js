import $ from 'jquery';
function counter() {
  handleQuantityChange();
  minusQuantity();
  plusQuantity();
  updateTotalPrice();
}
function minusQuantity() {

  $('.btn-minus').on('click', function (e) {
    e.preventDefault();
    const productId = $(this).data('product-id');
    const productElement = $('#product-' + productId);
    const cartId = $('#carts').data('cart-id');

    const quantityInput = $(this).closest('.quantity-input').find('.quantity');
    const quantity = parseInt(quantityInput.val());

    let path = window.location.pathname;

    if (quantity > 1) {
      quantity -= 1;
      quantityInput.val(quantity);
      updatePriceItem(productElement);
    } else if (quantity === 1) {
      if (path.includes('cart')) {
        if (confirm('Remove this product?')) {
          $.ajax({
            method: "POST",
            url: 'cart/remove-item',
            data: {
              product_id: productId,
              cart_id: cartId
            },
            success: function (response) {
              if (response.status === 200) {
                $('#product-' + productId).remove();
                if ($('.list-item .item').length === 0) {
                  $('.my-carts').html('<p>Your cart is empty. Add items to start shopping!</p>');
                }
              } else {
                console.log(response)
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log("AJAX request failed: " + textStatus + ", " + errorThrown);
            }
          })
        }
      }
    }
  })
  updateTotalPrice();
}
function plusQuantity() {

  $('.btn-plus').on('click', function (e) {
    e.preventDefault();

    var productId = $(this).data('product-id');
    var product = $('#product-' + productId);

    var quantityInput = $(this).closest('.quantity-input').find('.quantity');
    var quantity = parseInt(quantityInput.val());

    var stock = parseInt(quantityInput.attr('max'));
    if (quantity < stock) {
      quantity += 1;
      quantityInput.val(quantity);
      updatePriceItem(product);
      updateTotalPrice();
    }
  })
}

function updatePriceItem(productElement) {
  var priceText = $(productElement).find('.price_out').text();
  var price = parseFloat(priceText.replace(/,/g, ''));

  var quantityInput = parseInt($(productElement).find('input[type="number"]').val());

  var total = price * quantityInput;

  $(productElement).find('.products-price').html(total.toLocaleString());
}

export function updateTotalPrice() {
  var total = 0;
  $('.list-item .item').each(function () {
    var priceText = $(this).find('.products-price').text();
    var priceItem = parseFloat(priceText.replace(/,/g, ''));
    total += priceItem;
  });

  $('.purchase-final').html(total.toLocaleString());
}

function handleQuantityChange() {
  const stock = parseInt($('.quantity').attr('max'));

  $('.quantity').on('change blur', function () {
    const quantityInput = $(this).closest('.quantity-input').find('.quantity');
    const product = $(this).closest('.item');

    let quantity = parseInt(quantityInput.val());

    if (isNaN(quantity)) {
      $(this).val($(this).attr('min')); c
    }
    if (quantity > stock) {
      $(this).val($(this).attr('max'));
    }
    updatePriceItem(product);
    updateTotalPrice();
  });
}

export default counter;