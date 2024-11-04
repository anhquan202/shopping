<?php
$routes = [
  '' => 'HomeController@index',
  'products' => 'ProductController@index',
  'productDetail' => 'ProductDetailController@index',
  'cart' => 'CartController@index',
  'login' => 'AuthController@loginPage',
  'signup' => 'AuthController@signupPage',
  //api route
  'cart/add-to-cart' => 'CartController@addToCart',
  'cart/counter-cart' => 'CartController@counterCart',
  'cart/remove-item' => 'CartController@removeItem',
  'cart/get-total-price' => 'CartController@getTotalPrice',
  'register' => 'AuthController@register',
  'signin' => 'AuthController@signin'
];
