import 'selectize';

(function($) {
	const feather = require('feather-icons');
	
	feather.replace();
	
	$(document).ready(() => {
		feather.replace();

		$('.button-dropdown').selectize(
//			{
//			onInitialize: function () {
//				this.$control_input.attr('readonly', true);
//			}
//			}
		);
		
		document.body.style.setProperty('--cp-header-height', document.getElementById('masthead').offsetHeight + 'px');
	} );
	
})(jQuery);