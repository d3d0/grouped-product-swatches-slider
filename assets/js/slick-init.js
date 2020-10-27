jQuery(document).ready(function($){
	let $slider = $('.slider-container');

	$slider.on('init', function(event, slick){
		 	if (slick.slideCount == 1) var calc = ( 0 / (slick.slideCount) ) * 100;
			else var calc = ( 1 / (slick.slideCount) ) * 100;
			$(this).find('.progress').css('background-size', calc + '% 100%').attr('aria-valuenow', calc );
			$(this).parent().find('.slick-prev').css( 'opacity', 0.2);
	});

  $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
			// 0,1 > 1 / 3 > 2 / 3
			// 1,2 > 2 / 3 > 3 / 3
			// 2,0 > 0 / 3 > 1 / 3
			// alert('corrente: '+currentSlide+' successiva: '+nextSlide+' tot: '+slick.slideCount);
	    var calc = ( (nextSlide+1) / (slick.slideCount) ) * 100;
			$(this).find('.progress').css('background-size', calc + '% 100%').attr('aria-valuenow', calc );
			if (nextSlide >= 0 && nextSlide <= slick.slideCount-1) {
				$(this).parent().find('.slick-arrow').css( 'opacity', 1);
				$(this).parent().find('.slick-arrow').css( 'cursor', 'pointer');
			}
			if (nextSlide == 0) {
				$(this).parent().find('.slick-prev').css( 'opacity', 0.2);
				$(this).parent().find('.slick-prev').css( 'cursor', 'default');
			}
			if (nextSlide == slick.slideCount-1) {
				$(this).parent().find('.slick-next').css( 'opacity', 0.2);
				$(this).parent().find('.slick-next').css( 'cursor', 'default');
			}
  });

	 $slider.slick({
    infinite: false,
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: true,
	  fade: true,
	});
});
