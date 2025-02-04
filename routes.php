<?php
$routes = [
  '' => 'HomeController@index',
  'products' => 'ProductController@index',
  'productDetail' => 'ProductDetailController@index',
  'cart' => 'CartController@index',
  'login' => 'AuthController@loginPage',
  'complete-profile' => 'UserController@index',
  'signup' => 'AuthController@signupPage',
  'checkout' => 'CheckoutController@index',
  'thanks' => 'ThankyouController@index',
  //api route
  'cart/add-to-cart' => 'CartController@addToCart',
  'cart/counter-cart' => 'CartController@counterCart',
  'cart/remove-item' => 'CartDetailController@removeItem',
  'register' => 'AuthController@register',
  'signin' => 'AuthController@signin',
  'login/redirect-google' => 'AuthController@authWithGoogle',
  'complete-profile-user-after-oauth' => 'UserController@completeProfileUserAfterOauth',
  'get-user-info' => 'UserController@getUserInfo',
  'logout' => 'AuthController@logout',
  'checkoutByVNPay' => 'CheckoutController@checkoutByVNPay',
  'saveOrder' => 'ThankyouController@saveOrder'
];
