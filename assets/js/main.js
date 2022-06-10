(function($) {
	const feather = require('feather-icons');
	
	feather.replace();
	
	$(document).ready(() => {
		feather.replace();
		
		document.body.style.setProperty('--cp-header-height', document.getElementById('masthead').offsetHeight + 'px');
	} );
	
})(jQuery);