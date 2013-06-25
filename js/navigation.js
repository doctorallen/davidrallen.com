$(document).ready(function(){
	$('.nav a').click( function(e){
		e.preventDefault();
		history.pushState({ path: this.path}, '', this.href);
		$.get(this.href + '?ajax=true', function(data){
			$('#main').html(data);
		});
	});
});
