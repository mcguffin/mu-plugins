(function($){
	function load_fragments(e) {
		var req = {
			'action':'get_email_fragments'
		};
		$.post(email_obfuscator.ajax_url,req,function(response){
			$('[data-load-fragment]').each(function(){
				var hash = $(this).data('load-fragment');
				$(this).replaceWith(response[hash]);
			})
		})
	}
	$(document).one('click','[data-load-fragment]',load_fragments)
	$(document).ready(function(){
		if ( $('[data-load-fragment]').length ) {
			setTimeout(load_fragments,500);
		}
	});
})(jQuery);