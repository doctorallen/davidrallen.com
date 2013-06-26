$(document).ready(function(){
	$('.nav a').click( function(e){
		$('.nav a').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		if( validateURL(this.href) ){
			history.pushState({ path: this.path}, '', this.href);
			$.get(this.href + '?ajax=true', function(data){
				$('#main').html(data);
			});
		}
	});
	$(window).bind('popstate', function(){
		$.get(location.pathname + '?ajax=true', function(data){
			$('#main').html(data);
		});
	});
	function validateURL(URL){
		if (window.location.href === URL ){
			return false;
		}
		return true;
	}
});
