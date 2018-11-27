(function( $, args ) {
	var key = atob( args.key ),
		len = key.length;

	$('[data-obfuscated]').each( function() {
		$(this).replaceWith( (function( str, d ) {
			// simple char rotation
			return str.split('').map( function(s,i) {
				return String.fromCharCode( ( 256 + s.charCodeAt(0)+ key.charCodeAt( i % len ) * d ) % 256 );
			}).join('');
		})( atob( $(this).data('obfuscated') ), -1 ) );
	})
})( jQuery, email_obfuscator );
