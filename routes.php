<?php
$routes = [
  '' => 'HomeController@index',
  'products' => 'ProductController@index',
  'productDetail' => 'ProductDetailController@index',
  'cart' => 'CartController@index',

  //api route
  'cart/add-to-cart' => 'CartController@addToCart',
  'cart/counter-cart' => 'CartController@counterCart',
  'cart/remove-item' => 'CartController@removeItem',
  'cart/get-total-price' => 'CartController@getTotalPrice'
];
