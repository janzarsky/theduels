setInterval(function () {
	$.getJSON('overview/data', function ( data ) {
		var windowHeight = $(window).outerHeight();
		var windowWidth = $(window).outerWidth();
		
		var margin = 16;
		var imageSize = 100;
		
		$.each(data, function(key, val) {
			console.log(key, val);
			
			var player = $('#' + key);
			
			var left = val.x*windowWidth;
			var top = val.y*windowHeight;
			
			var width = player.outerWidth()/player.outerHeight()*imageSize*val.scale;
			var height = imageSize*val.scale;
			
			left = (left - width/2 < margin) ? margin + width/2 : left;
			left = (left + width/2> windowWidth - margin) ? windowWidth - margin - width/2 : left;
			
			top = (top - height/2 < margin) ? margin + height/2 : top;
			top = (top + height/2 > windowHeight - margin) ? windowHeight - margin - height/2 : top;
			
			left -= width/2;
			top -= height/2;
			
			player.animate({
				'left': left + 'px',
				'top': top + 'px'
			}, 400);
			player.children('.player__name').animate({
				'font-size': val.scale + 'em'
			}, 400);
			player.children('.player__image').animate({
				'height': imageSize*val.scale + 'px'
			}, 400);
		});
	});
}, 500);
