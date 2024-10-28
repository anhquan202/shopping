import $, { error } from 'jquery';
import { updateTotalPrice } from './counter';
function handleCart() {
  addToCart();
  updateCartCount();
  removeItem();
}

function addToCart() {
  $('.btn_add-to-cart').on('click', function (e) {
    e.preventDefault();

    var productId = $(this).data('product-id');
    var quantity = $('.quantity').val();

    $.ajax({
      method: "POST",
      url: 'cart/add-to-cart',
      data: {
        product_id: productId,
        quantity: quantity
      },
      success: function (response) {
        if (response.success === 200) {
          alert(response.message);
          updateCartCount();
        } else if (response.success === 401) {
          alert(response.message);
          window.location.href = 'login';
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX request failed: " + textStatus + ", " + errorThrown);
      }
    })
  })
}

//handle counter cart and show in cart-icon
function updateCartCount() {
  $.ajax({
    method: "POST",
    url: 'cart/counter-cart',
    success: function (response) {
      if (response.success === 200) {
        $('#shopping-cart').text(response.total_items);
      } else {
        console.log('Error fetching cart count');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("AJAX request failed: " + textStatus + ", " + errorThrown);
    }
  });
}

function removeItem() {
  $('.btn-remove').on('click', function (e) {
    e.preventDefault();
    var productId = $(this).data('product-id');
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
    updateTotalPrice();
  })
}
export default handleCart;