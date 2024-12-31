import $, { error } from 'jquery';
import { getUserInfoFromApi } from './handleUserInfo';
import { updateTotalPrice } from './counter';
function handleCart() {
  addToCart();
  removeItem();
}

function addToCart() {
  $('.btn_add-to-cart').on('click', async function (e) {
    e.preventDefault();
    var productId = $(this).data('product-id');
    var quantity = $('.quantity').val();
    try {
      const user = await getUserInfoFromApi();
      const userId = user.user_id;
      $.ajax({
        method: "POST",
        url: 'cart/add-to-cart',
        data: {
          user_id: userId,
          product_id: productId,
          quantity: quantity
        },
        success: function (response) {
          if (response.status === 200) {
            alert(response.message);
            updateCartCount();
          }
        },
        error: function (error) {
          console.log(error);
        }
      })
    } catch (error) {
      alert(error.message);
      window.location.href = 'login';
    }
  })
}

//handle counter cart and show in cart-icon
export function updateCartCount() {
  try {
    $.ajax({
      method: "POST",
      url: 'cart/counter-cart',
      success: function (response) {
        if (response.status === 200) {
          $('#shopping-cart').text(response.total_items);
        } else {
          console.log('Error fetching cart count');
        }
      },
      error: function (xhr) {
        console.log(xhr.responseText);
      }
    });
  } catch (xhr) {
    console.log(xhr);
  }
}

function removeItem() {
  $('.btn-remove').on('click', function (e) {
    e.preventDefault();
    const cartId = $('#carts').data('cart-id');
    const productId = $(this).data('product-id');
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
  })
  updateTotalPrice();
}
export default handleCart;