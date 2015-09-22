(function($) {
	$(document).ready(function(){
		$( '#update-plugins-table' ).find( 'a' ).each(function( i, e ){
			var $link = $( e );
			if( 0 == $link.attr( 'title' ).search( "Wonster" ) || 0 == $link.attr( 'title' ).search( "Revolution" ) || 0 == $link.attr( 'title' ).search( "WPBakery" ) ){
				$link.hide();
				var $p	= $link.parent( 'p' );
				var tx	= $p.html();
				var re = new RegExp(wtr_update_plugin.unknown, 'g');
				$p.html( tx.replace( re, wtr_update_plugin.according_to_its_author) );
			}
		});
	});
})(jQuery);