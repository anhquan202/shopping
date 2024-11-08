import $ from 'jquery';

function automaticSlide() {
  let slideIndex = 0;
  let slides = $('.mySlides');
  let dots = $('.dot');
  function showSlides() {
    $(slides).removeClass('active').hide();
    $(dots).removeClass('active');

    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
    }

    $(slides[slideIndex - 1]).show().addClass('active');
    $(dots[slideIndex - 1]).addClass('active');

    setTimeout(showSlides, 3000);
  }
  setTimeout(showSlides, 3000);
  
}
export default automaticSlide;