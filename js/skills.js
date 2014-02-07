$(document).ready( function(){
	console.log('load rahpael');
	var o = {
	  init: function(id, size, type){
		this.diagram(id, size, type);
	  },
		random: function(l, u){
		  return Math.floor((Math.random()*(u-l+1))+l);
		},
		  diagram: function(id, size, type){
			var r = Raphael(id, size, size),
			  defaultText = id.charAt(0).toUpperCase() + id.slice(1),
			  speed = 250,
			  items = $('#' + id).find('.get').find('.arc').size(),
			  half = size/2,
			  stroke = size/(items * 5),
			  strokeTo = stroke * 2,
			  radPadding = stroke + (stroke / 5),
			  mainRadius = size / 5,
			  rad = mainRadius - (stroke /2 );

			  r.circle(half, half, mainRadius).attr({ stroke: 'none', fill: '#383332' });

			var title = r.text(half, half, defaultText).attr({
			  font: '20px Arial',
				fill: '#fff'
			}).toFront();
			r.customAttributes.arc = function(value, color, rad){
			  //radius value of the percentage
			  var v = 360 / 100 * value,
				//if v is 360, it will end where it starts, we want to make sure it doesn't
				alpha = v == 360 ? 359.99 : v,
				//generate a random radius between 91 and 240 degrees for the starting point if the type is set to random
				start = (type == 'random' ? o.random(91, 240) :  0),
				//ending angle in radians
				a = (start-alpha) * Math.PI/180,
				//starting angle in radians
				b = start * Math.PI/180,
				//startpoint x is center plus the padding * cosine of the start angle
				sx = half + rad * Math.cos(b),
				//startpoing y is center minus the padding * sine of the start angle
				sy = half - rad * Math.sin(b),
				//endpoint x is center plus the padding * cosine of the end angle
				x = half + rad * Math.cos(a),
				//endpoint y is center minus the padding * sine of the end angle
				y = half - rad * Math.sin(a),
				//draw the path
				   /*
				   * sx = starting x
				   * sy = starting y
				   * draw the arc 'A' is arc flag, 
				   * rad is the x and y radius
				   * 0 is the x-axis rotation 
				   * +(alpha>180) is the large-arc-flag (determines if the arc is > or < 180 degrees) 
				   * 1 is the sweep-flag (determines which direction to draw the arc)
				   * x = ending x 
				   * y = ending y 
					*/
				path = [
				   ['M', sx, sy], 
				   ['A', rad, rad, 0, +(alpha > 180), 1, x, y]
				];
				console.log('a:' + a + ' b:' + b + 'sx:' + sx + ' sy:' + sy + ' x:' + x + ' y:' + y + ' percent:' + value + ' alpha:' + alpha + ' rad:' + rad);
				  return { path: path, stroke: color }
			}
			$('#' + id).find('.get').find('.arc').each(function(i){
			  var t = $(this), 
			  color = t.find('.color').val(),
			  value = t.find('.percent').val(),
			  text = t.find('.text').text();
			  rad += radPadding;  
			  var z = r.path().attr({ arc: [value, color, rad], 'stroke-width': stroke });

			  z.mouseover(function(){
				this.animate({ 'stroke-width': strokeTo, opacity: .75 }, 1000, 'elastic');
				if(Raphael.type != 'VML') //solves IE problem
				  this.toFront();
				title.stop().animate({ opacity: 0 }, speed / 2, '>', function(){
				  this.attr({ text: text + '\n' + value + '%' }).animate({ opacity: 1 }, speed / 2, '<');
				});
			  }).mouseout(function(){
				this.stop().animate({ 'stroke-width': stroke, opacity: 1 }, speed*4, 'elastic');
				title.stop().animate({ opacity: 0 }, speed / 2, '>', function(){
				  title.attr({ text: defaultText }).animate({ opacity: 1 }, speed /2 , '<');
				}); 
			  });
			});
		  }
	}
$(document).on('ajaxLoad', function(e, options){	
	if( options && options.slug == 'skills'){
		o.init('languages', 300);
		o.init('databases', 300);
		o.init('frameworks', 300);
		o.init('libraries', 300);
		o.init('platforms', 300);
		o.init('cms', 300);
		o.init('software', 300);
		o.init('os', 300); 
		o.init('server', 300);
		o.init('amazon', 300); 
	}
	 });
 });
