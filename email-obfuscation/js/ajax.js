(function($,args){
	var to;

	function load_fragments(e) {
		!! to && clearTimeout(to);
		var req = {
			action: 'get_email_fragments',
		};
		!!e && e.type === 'click' && e.preventDefault();
		$.ajax({
			url: args.ajax_url,
			type:'post',
			data: req,
			success:function( response ) {
				$('[data-load-fragment]')
					.each(function(){
						var hash = $(this).attr('data-load-fragment');
						!!response[hash] && $(this).replaceWith( response[hash] );
					});
			}
		});
	}
	$(window)
		.one('load', function(){
			to = setTimeout(load_fragments,500);
		} );
	$(window).one('scroll mousemove mousedown', load_fragments );
	$(document)
		.one('click','[data-load-fragment]',load_fragments)

})( jQuery, email_obfuscator );
