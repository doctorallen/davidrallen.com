var months = {1: 'January', 2:'Feburary', 3:'March', 4:'April', 5:'May', 6:'June', 7:'July', 8:'August', 9:'September', 10:'October', 11:'November', 12:'December'};

var dates = [];

var timeline =[];

var speed = 250;

$('.timeline').find('.timeline-item').each( function(){
    var t = $(this),
        d = t.data('date'),
        s = d.split('-'),
        year = parseInt(s[0]),
        month = parseInt(s[1]),
        day = parseInt(s[2]) ? parseInt(s[2]) : 1,
        title = t.find('.title').html(),
        description = t.find('.description').html(),
        date = {
          date: d,
          year: year,
          month: month,
          day: day,
          title: title,
          description: description,
          monthName: months[month]
      };
  dates.push(date);


});
  //sort the dates
  dates.sort(dynamicSortMultiple('year', 'month', 'day'));

  //group the dates by year and month
  dates.forEach( function(date) {
    console.log(date);
    if( !timeline[date.year] ){
      timeline[date.year] = [];
    }
    if( !timeline[date.year][date.month]){
      timeline[date.year][date.month] = [];
    }
    timeline[date.year][date.month].push(date);
  });

  console.log(timeline);
  //build the timeline graph
  $('.timeline-graph').append('<div class="timeline-nav"></div>');
  $('.timeline-graph').append('<div class="timeline-description"></div>');
  var i = 0;
  timeline.forEach( function( years, year) {
    $('.timeline-nav').append('<div id="' +year+'" class="year">'+year+'</div>');
    years.forEach( function( monthArray, month ){
      $('#'+year).append('<div id="' +year+'-'+month+'" class="month">'+months[month]+'</div>');
      monthArray.forEach( function( date ){
        $('#'+year+'-'+month).append('<div data-id="'+i+'" id="date-'+i+'" class="date">'+date.title+'</div>');
        $('.timeline-description').append('<div id="description-'+i+'" class="description">'+date.description+'</div>');
        i++;
      });
    });
  });

$('.date').click( function(e){
e.stopPropagation();
  var t = $(this),
      d = $('#description-' + t.data('id'));
    console.log('click');
    $.when(
      $('.description').fadeOut(speed)
    ).done( function(){
      $('.description').removeClass('active');
      fade(d);
    });
});

$('.month').click( function(e){
e.stopPropagation();
  var t = $(this),
      d = t.find('.date');
      fade(d);
});

$('.year').click( function(e){
e.stopPropagation();
  var t = $(this),
      d = t.find('.month');
      fade(d);
});

function fade(d){
  if( d.hasClass('active') || d.is(':visible') ){
    d.fadeOut(speed);
    d.removeClass('active');
  }else{
    d.addClass('active');
    d.fadeIn(speed);
  }
}

function dynamicSort(property) {
    var sortOrder = 1;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1, property.length - 1);
    }
    return function (a,b) {
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

function dynamicSortMultiple() {
    /*
     * save the arguments object as it will be overwritten
     * note that arguments object is an array-like object
     * consisting of the names of the properties to sort by
     */
    var props = arguments;
    return function (obj1, obj2) {
        var i = 0, result = 0, numberOfProperties = props.length;
        /* try getting a different result from 0 (equal)
         * as long as we have extra properties to compare
         */
        while(result === 0 && i < numberOfProperties) {
            result = dynamicSort(props[i])(obj1, obj2);
            i++;
        }
        return result;
    }
}
