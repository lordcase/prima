(function($) {
	$(document).ready(function(){
		var wtr_up_div = [ '#revolution-slider', '#wonster-shortcodes-for-visual-composer-symetrio-edition', '#wonster-classes-schedule-symetrio-edition', '#wonstercustom-type-symetrio-edition', '#wpbakery-visual-composer' ];

		$.each( wtr_up_div, function( i, e ){
			$( e + ' .thickbox').remove();
			var $row = $( e ).next( '.plugin-update-tr' );
			$row.find( '.thickbox' ).remove();
			var $obj	= $row.find( '.update-message' );
			var a		= $obj.find( 'a' )[ 0 ];
			var tex		= $obj.text().split( '.' )[ 0 ];
			$obj.html( tex + ' - ' );
			$obj.append(a);
		});
	});
})(jQuery);

