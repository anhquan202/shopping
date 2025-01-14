import $ from 'jquery';
import layout from './layout';
$(function () {
  layout();

  const pageName = $('body').data('page');

  switch (pageName) {
    case 'home':
      import('./pages/home.js').then(module => module.default());
      break;
    case 'productDetail':
      import('./pages/productDetail.js').then(module => module.default());
      break;
    case 'signup':
      import('./pages/signup.js').then(module => module.default());
      break;
    case 'login':
      import('./pages/login.js').then(module => module.default());
      break;
    case 'carts':
      import('./pages/carts.js').then(module => module.default());
      break;
    case 'checkout':
      import('./pages/checkout.js').then(module => module.default());
      break;
    case 'thanks':
      import('./pages/thanks.js').then(module => module.default());
      break;
    default:
      console.warn(`No script found for page: ${pageName}`);
      break;
  }
});