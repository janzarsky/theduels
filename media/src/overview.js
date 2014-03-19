setInterval(function () {
	$.getJSON('overview/data', function ( data ) {
		var windowHeight = $(window).outerHeight();
		var windowWidth = $(window).outerWidth();
		
		$.each(data, function(key, val) {
			console.log(key, val);
			
			var player = $('#' + key);
			
			var left = val.x*windowWidth - (player.outerWidth()/2);
			var top = val.y*windowHeight - (player.outerHeight()/2);
			
			left = (left < 0) ? 0 : left;
			left = (left > windowWidth) ? windowWidth : left;
			
			top = (top < 0) ? 0 : top;
			top = (top > windowHeight) ? windowHeight : top;
			
			player.animate({
				'left': left + 'px',
				'top': top + 'px'
			}, 400);
			player.children('.player__name').animate({
				'font-size': val.scale + 'em'
			}, 400);
			player.children('.player__image').animate({
				'height': 300*val.scale + 'px'
			}, 400);
		});
	});
}, 500);