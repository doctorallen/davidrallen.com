function() {
	$(".image").click(function() {
			var image = $(this).attr("rel");
			$('#image').hide();
			$('#image').fadeIn('slow');
			$('#image').html('<img src="' + image + '"/>');
			return false;
	});
});
