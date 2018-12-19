import 'jquery'
import 'slick-carousel'

export default {
  init() {
    // JavaScript to be fired on the home page
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
    $('.client-slides').slick({
      dots: true,
      speed: 3000,
      arrows: false,
      autoplay: true,
      infinite: true,
      slidesToShow: 1,
      mobileFirst: true,
      adaptiveHeight: true,
    });
    
  },
};
