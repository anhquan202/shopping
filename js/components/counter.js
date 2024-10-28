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
    var productId = $(this).data('product-id');
    var productElement = $('#product-' + productId);

    var quantityInput = $(this).closest('.quantity-input').find('.quantity');
    var quantity = parseInt(quantityInput.val());

    var path = window.location.pathname;

    if (quantity > 1) {
      quantity -= 1;
      quantityInput.val(quantity);
      updatePriceItem(productElement);
      updateTotalPrice();
    } else if (quantity === 1) {
      if (path.includes('cart')) {
        if (confirm('Remove this product?')) {
          $.ajax({
            method: "POST",
            url: 'cart/remove-item',
            data: {
              product_id: productId
            },
            success: function (response) {
              if (response.success === 200) {
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
    console.log(total);

  });

  $('.purchase-final').html(total.toLocaleString());
}

function handleQuantityChange() {
  $('.quantity').on('change', function () {
    var quantityInput = $(this).closest('.quantity-input').find('.quantity');
    var quantity = parseInt(quantityInput.val());
    var product = $(this).closest('.item');

    if (isNaN(quantity)) {
      $(this).val($(this).attr('min'));
    }
    updatePriceItem(product);
    updateTotalPrice();
  });
}

export default counter;