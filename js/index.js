import $ from 'jquery';
import automaticSlide from './components/showSlide';
import redirectToProductDetail from './components/redirectToProductDetail';
import handleCart from './components/cart';
import counter from './components/counter';
import showHideLabel from './components/showHideLabel';
import register from './auth/register';
import signin from './auth/signin';
import getInforUser from './components/userTokenHandler';
$(function () {
  automaticSlide();

  redirectToProductDetail();

  handleCart();

  counter();

  showHideLabel();

  register();

  signin();

  getInforUser();
});