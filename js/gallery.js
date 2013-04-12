$(document).on('ready', function(){
    //first we need to build the element object
    var images = [];
    var thumbnails = [];
    var padding = 15;
    var switching = false;
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
          thumbnails[i] = {
            id: item_name,
            src: li.find('div').css('background-image')
          };
          i = i + 1;
        });
    });
  generateThumbnails();

	$("#prev").click(function() {
      previous();
	});

	$("#next").click(function() {
      next();
	});

  $('.thumbnail').click(function() {
    if( switching == false){
          switching = true;
          var li = $('.gallery ul .active');
          var active_element = li.attr('id');
          $('.thumbnail').removeClass('active');
          $(this).addClass('active');
          var id = $(this).data('id');
             $('#' + active_element).fadeOut(200, function(){ 
                $('#' + active_element).removeClass('active');
                 $('#' + id).fadeIn(200, function(){
                    $('#' + id).addClass('active');
                      switching = false;
                  });
              });
        }
  });

  $('.gallery').mouseenter( function() {
      setControls();
      showControls();
  });

  $('.gallery').mouseleave( function(){
      hideControls();
  });

  $('.gallery').click( function() {
      next();
  });

  function previous(){
    if(switching == false){
      switching = true;
      hideControls();
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
                  var thumb = $('*[data-id="' + prev_idx + '"]');
                  $('.thumbnail').removeClass('active');
                  updateThumb(prev_idx);
                  setControls();
                  switching = false;
              });
          });
        return false;
    }
  }

  function next(){
    if( switching == false ){
      switching = true;
      hideControls();
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
                updateThumb(prev_idx);
                setControls();
                switching = false;
            });
        });
			return false;
    }
  }

  function updateThumb(prev_idx){
    var thumb = $('*[data-id="' + prev_idx + '"]');
    var thumbPosition = thumb.position();
    var container = $('#thumbnail-container');
    console.log(thumbPosition);
    console.log(container);
    $('.thumbnail').removeClass('active');
    thumb.addClass('active');
    console.log(thumbPosition);
    console.log(container.height());
    if( thumbPosition.top > container.height() || thumbPosition.top < 0 ){
      container.scrollTop(thumbPosition.top + container.scrollTop() - 30);
    }
  }

  function hideControls(){
    var left = $('#prev');
    var right = $('#next');
    left.css('display', 'none');
    right.css('display', 'none');
  }

  function showControls(){
    var left = $('#prev');
    var right = $('#next');
    left.fadeIn(200);
    right.fadeIn(200);
  }

  function setControls(){
    var left = $('#prev');
    var right = $('#next');
    var li = $('.gallery ul .active');
    var active_element = li.attr('id');
    var div = li.find('div');
    var position = div.position();
    var width = div.width();
    left.css('left', position.left + padding);
    right.css('left', position.left + width - right.width() - padding);
    showControls();
  }

  function generateThumbnails(){
    $('.gallery').prepend('<div id="thumbnail-container"></div>');
    var i = 0;
    $.each( thumbnails,  function (index, thumbnail) {
      $('#thumbnail-container').append('<li class="thumbnail" data-id="' + thumbnail.id + '"><div class="thumbnail-image-container"style="background-image:' + thumbnail.src + '"></div></li>');
        if( i === 0 ){
          $('.thumbnail').addClass('active');
        }
      i++;
    });
  }


  $(document).keydown(function(e){
      if (e.keyCode == 37) { 
        previous();
      }
      if (e.keyCode == 39) { 
        next();
      }
  });
});
