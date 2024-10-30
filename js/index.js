import $ from 'jquery';
import automaticSlide from './components/showSlide';
import redirectToProductDetail from './components/redirectToProductDetail';
import handleCart from './components/cart';
import counter from './components/counter';
import showHideLabel from './components/showHideLabel';
$(function () {
  automaticSlide();

  redirectToProductDetail();

  handleCart();

  counter();

  showHideLabel();
});