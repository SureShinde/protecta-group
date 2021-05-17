var config = {
	paths: { 
		'digital/homebanner': 'Digital_Homebanner/js/owl.carousel.min',			 
		'digital/homebannerscroll': 'Digital_Homebanner/js/jquery.jscrollpane.min',			 
		'digital/homebannermousewheel': 'Digital_Homebanner/js/jquery.mousewheel',
		'digital/unveil': 'Digital_Homebanner/js/jquery.unveil',
	},
	shim: {		 
		'digital/homebanner': {
			deps: ['jquery']
		},
		'digital/homebannerscroll': {
			deps: ['jquery']
		},
		'digital/homebannermousewheel': {
			deps: ['jquery']
		},
		'digital/unveil': {
			deps: ['jquery']
		},
	}
};
