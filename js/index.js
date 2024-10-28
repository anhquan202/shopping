import $ from 'jquery';
import automaticSlide from './components/showSlide';
import redirectToProductDetail from './components/redirectToProductDetail';
import handleCart from './components/cart';
import counter from './components/counter';
$(function () {
  automaticSlide();

  redirectToProductDetail();

  handleCart();

  counter();
});