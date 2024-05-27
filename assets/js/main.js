jQuery(document).ready(function($) {
	"use strict"
	const maximum = $('#price-max').val();
	const minimum = $('#price-min').val();

	filter_func();

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	})

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	$('#product-main-img').slick({
		infinite: true,
		speed: 300,
		dots: false,
		arrows: true,
		fade: true,
		asNavFor: '#product-imgs',
  	});

	// Product imgs Slick
	$('#product-imgs').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: true,
		centerMode: true,
		focusOnSelect: true,
			centerPadding: 0,
			vertical: true,
		asNavFor: '#product-main-img',
		responsive: [{
			breakpoint: 991,
			settings: {
				vertical: false,
				arrows: false,
				dots: true,
			}
      	},
    	]
  	});

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

	// Input number
	
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		});

		up.on('click', function () {
			var at = $input.attr('max');
			var value = parseInt($input.val()) + 1;
			if (at !== "undefined" && at !== "false") {
				value = value > at ? at : value;
			}
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		});
	});

	var priceInputMax = document.getElementById('price-max'),
			priceInputMin = document.getElementById('price-min');

	priceInputMax.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	priceInputMin.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			priceSlider.noUiSlider.set([value, null]);
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
		}
	}

	// Price Slider
	var priceSlider = document.getElementById('price-slider');
	if (priceSlider) {
		noUiSlider.create(priceSlider, {
			start: [minimum, maximum],
			connect: true,
			step: 1,
			range: {
				'min': parseInt(minimum),
				'max': parseInt(maximum)
			}
		});

		priceSlider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			handle ? priceInputMax.value = value : priceInputMin.value = value
			filter_func();
		});
	}

	// Filter
	function filter_func() {
		const category = create_filter("category-filter");
		const brand = create_filter("brand-filter");
		const min = $('#price-min').val();
		const max = $('#price-max').val();
		const page = $('#page').val();
		const sortby = $('.sorting.input-select').find(':selected').val();
		$.ajax({
			url: '../_inc/config.php',
			method:'GET',
			data: {action:'filter', minimum:min, maximum:max, category:category, brand:brand, page:page, sortby:sortby},
			success: function(data) {
				var arr = data.split(' ; ');
				$('.store-items').html(arr[0]);
				var str = arr[1] ==  1 ? ' product' : ' products';
				$('.store-qty').html('Showing ' + arr[1] + str);
			},
		});
	}

	function create_filter(value) {
		var filter = [];
		$('.' + value + ':checked').each(function() {
			filter.push($(this).val());
		});
		return filter;
	}

	$('.check-filter').click(function() {
		filter_func();
	});

	$('.sorting.input-select').change(function() {
		filter_func();
	})
});