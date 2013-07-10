$(document).ready(function(){
	var navigating = false;
	$('.nav a').click( function(e){
		e.preventDefault();
		if(navigating == false){
			navigating = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');
			if( validateURL(this.href)){
				history.pushState({ path: this.path}, '', this.href);
				//create the div to put the content into
				///load the content
				$.get(this.href + '?ajax=true', function(data){
					loadPage(data);
				});
			}else{
				navigating = false;
			}
		}
	});
	function loadPage(data){
		$('#main').before('<div class="sideload"></div>');
		var loader = $('.sideload');
		//remove any already existing sideloaders
		//insert content into the div
		var speed = 500;
		loader.html(data);
		loader.slideDown(speed, function(){
			loader.removeClass('sideload');
		});
		setTimeout(function(){
			$('#main').slideUp(function(){
				$(this).remove();
			});

			loader.attr('id', 'main');
			navigating = false;
		}, speed - 200);
	}
	$(window).bind('popstate', function(){
		$.get(location.pathname + '?ajax=true', function(data){
			loadPage(data);
			$('.nav li').removeClass('active');
			$('.nav .' + location.pathname.substring(1)).addClass('active');
			console.log(location);
		});
	});
	function validateURL(URL){
		if (window.location.href === URL ){
			return false;
		}
		return true;
	}
});
