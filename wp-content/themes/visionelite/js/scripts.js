jQuery(document).ready(function($){

	// GLOBAL VARIABLES
	var $window = $(window);
	var vw = $(window).width();
	$(window).resize(function(){
		vw = $(window).width();
	});


    // fill the height of the divs
	$window.scroll(function() {
		if( ($('#become_a_sponsor_impact').visible() && vw > 768) || ($('#become_a_sponsor_impact').visible(true) && vw < 768 ) ){
            $('#become_a_sponsor_impact .col .fill').each(function(){
                var $this = $(this);
                var fillHeight = $this.attr('value');
                $this.css('height', fillHeight + '%');
            });
		}
		else{
            $('#become_a_sponsor_impact .col .fill').each(function(){
                var $this = $(this);
                $this.css('height', 0 + '%');
            });
		}
	});

	// testimonial slider
	if( $('#testimonials-slider').length ){
		$('#testimonials-slider').slick({
			dots: true,
			infinite: true,
			slidesToShow: 3,
			slidesToScroll: 1,
			speed: 500,
			cssEase: 'linear',
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: false,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1
					}
				}
			]
		});
	}

	// blog slider
	if( $('#blog-slider').length ){
		$('#blog-slider').slick({
		dots: true,
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		speed: 500,
		cssEase: 'linear',
		autoplay: true,
		autoplaySpeed: 5000,
		arrows: false,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			}
		]
		});
	}

	// event slider
	if( $('#event-slider').length ){
		$('#event-slider').slick({
		dots: false,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 500,
		cssEase: 'linear',
		autoplay: true,
		autoplaySpeed: 10000,
		arrows: true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					dots: true,
					arrows: false,
				}
			}
		]
		});
	}

	// slick slider equal height
	if( $('.slick-slider').length ){
		// calculate on page load
		$(document).ready(function(){
			$('.slick-slider').each(function(){
				var $this = $(this);
				var $slides = $this.find('.slick-slide:not(.slick-cloned) .bubble');
				var $allSlides = $this.find('.slick-slide .bubble');
				var maxHeight = 0;
				// find the max height of the slides
				$slides.each(function(){
					var $slide = $(this);
					if($slide.height() > maxHeight){
						maxHeight = $slide.height();
					}
				});
				// add 60 to maxHeight for the padding
				maxHeight += 60;
				// set the height of each slide to the maxHeight
				$allSlides.css('height', maxHeight + 'px');
			});
		});
	}

	// equal height items
	$('.equal-height-items').each(function(){
		const $items = $(this);
		var $item = $items.find('.item');
		if( $items.hasClass('z-section') ){
			$item = $items.find('.z-content');
		}
		var maxHeight = 0;
		// find the max height of the items
		$item.each(function(){
			if($(this).height() > maxHeight){
				maxHeight = $(this).height();
			}
		});
		// make adjustments for padding if needed
		//maxHeight = maxHeight;
		// set the height of each item to the maxHeight
		$items.find($item).css('height', maxHeight + 'px');
	});


	// remove map if #maperror exists
	if( $('#maperror').length ){
		$('#leaflet-map').remove();
		$('#maperror').remove();
	}


    // change button text on click for send-message
    $(document).on('click', '.form-actions button.btn', function () {
        const $button = $(this);
        $button.text('Sending ');
    });


	// convert singulear <a> links to small buttons
	$('p').each(function () {
		const $p = $(this);
		// Collect everything inside <p>, but ignore pure‑whitespace text nodes
		const meaningful = $p.contents().filter(function () {
			return this.nodeType === 1                       // any element node
			|| (this.nodeType === 3 && $.trim(this.nodeValue).length); // text with characters
		});
		// If the only meaningful child is an <a>, add the class
		if (meaningful.length === 1 && meaningful[0].nodeName.toLowerCase() === 'a') {
			$(meaningful[0]).addClass('sml-btn');
		}
	});


});