$(document).on('ready', function(){
    //first we need to build the element object
    var images = [];
    $('.gallery ul').each(function(){
      var i = 0;
         $(this).find('li').each( function() {;
          var li = $(this);
           //if this is the first item, make it active
           if( i === 0 ){
             li.addClass('active');
           }
          var li = $(this);
          var item_name = 'gallery_item_' + i;
          li.attr('id', item_name);
          images[i] = item_name;
          i = i + 1;
        });
    });
  function previous(){
     //find the currently active element 
      var li = $('.gallery ul .active');
       //grab the current index of the active element
       var active_element = li.attr('id');
       var idx =  images.indexOf(active_element);
       //now that we have the index, we are going to get the previous index
       var prev_idx = 0;
       if( idx === 0 ){
          //if the index is 0, we know it is the first element, so it needs to grab the last element
          prev_idx = images[images.length - 1];
        }else{
          //if the index is not 0, we know to grab the previous element
          prev_idx = images[idx - 1];
        }
       //change which element is active
       $('#' + active_element).fadeOut(200, function(){ 
          $('#' + active_element).removeClass('active');
           $('#' + prev_idx).fadeIn(200, function(){
              $('#' + prev_idx).addClass('active');
            });
        });
			return false;
  }

  function next(){
     //find the currently active element 
      var li = $('.gallery ul .active');
       //grab the current index of the active element
       var active_element = li.attr('id');
       var idx =  images.indexOf(active_element);
       //now that we have the index, we are going to get the previous index
       var prev_idx = 0;
       if( idx === (images.length -1 ) ){
          //if the index is the last one, we know it needs to grab the first element 
          prev_idx = images[0];
        }else{
          //if the index is not the last one, we know to grab the next element
          prev_idx = images[idx + 1];
        }
       //change which element is active
       $('#' + active_element).fadeOut(200, function(){ 
          $('#' + active_element).removeClass('active');
           $('#' + prev_idx).fadeIn(200, function(){
              $('#' + prev_idx).addClass('active');
            });
        });
			return false;
  }
	$("#prev").click(function() {
      previous();
	});

	$("#next").click(function() {
      next();
	});
  $(document).keydown(function(e){
      if (e.keyCode == 37) { 
        previous();
      }
      if (e.keyCode == 39) { 
        next();
      }
  });
  var downX = 0;
  var downY = 0;
  var upX = 0;
  var upY = 0;
  $('.gallery img').mousedown(function(e){
      e.preventDefault();
      downX = e.pageX - $(this).offset().left;
      downY= e.pageY - $(this).offset().top;
  });
  $('.gallery img').mouseup(function(e){
      e.preventDefault();
      upX = e.pageX - $(this).offset().left;
      upY= e.pageY - $(this).offset().top;
      console.log('DOWN X:', downX);
      console.log('DOWN Y:', downY);
      console.log('UP X:', upX);
      console.log('UP Y:', upY);
      $(this).html
  });

});
