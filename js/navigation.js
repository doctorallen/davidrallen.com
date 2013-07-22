$(document).ready(function(){
	//when the page loads initally, we don't want it to display anything
	$('#main').html('');
	var navigating = false;
	$('.nav a').click( function(e){
		e.preventDefault();
		if(navigating == false){
			navigating = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');
			if( validateURL(this.href)){
				history.pushState({ path: this.path}, '', this.href);
				var path = this.href.substring(this.href.lastIndexOf('/') + 1);
				//create the div to put the content into
				///load the content
				$.get(this.href + '?ajax=true', function(data){
					loadPage(data);
					changeTitle(path);
				});
			}else{
				navigating = false;
			}
		}
	});
	function changeTitle(title){
		title = title.replace(/\b[a-z]/g, function(letter){
			return letter.toUpperCase();
		});
		$(document).attr('title', "David Allen - " + title);
	}
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
			pathname = location.pathname.substring(1);
			if( location.pathname == '/' ){
				pathname = 'home';
			}
			$('.nav .' + pathname).addClass('active');
		});
	});
	function validateURL(URL){
		if (window.location.href === URL ){
			return false;
		}
		return true;
	}
	//Navigation tab
	var pathname = window.location.pathname;
	pathname = pathname.split("/");
	pathname = pathname[1];
	if(pathname == ''){
		pathname = 'home';
	}
	$('.' + pathname).addClass('active');
	changeTitle(pathname);
});
