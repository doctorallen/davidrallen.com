$(document).ready(function(){
	var navigating = false;
	$('.nav a').click( function(e){
		e.preventDefault();
		if(navigating == false){
			navigating = true;
			$('.nav a').removeClass('active');
			$(this).addClass('active');
			if( validateURL(this.href)){
				history.pushState({ path: this.path}, '', this.href);
				//create the div to put the content into
				$('#main').before('<div class="sideload"></div>');
				var loader = $('.sideload');
				///load the content
				$.get(this.href + '?ajax=true', function(data){
					//remove any already existing sideloaders
					//insert content into the div
					loader.html(data);
					loader.slideDown( function(){
						loader.removeClass('sideload');
					});

					$('#main').slideUp(function(){
						$(this).remove();
					});

					loader.attr('id', 'main');
					navigating = false;

				});
			}else{
				navigating = false;
			}
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
