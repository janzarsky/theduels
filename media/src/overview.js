setInterval(function () {
	var windowHeight = $(window).outerHeight();
	var windowWidth = $(window).outerWidth();
	
	$.getJSON('overview/data?w=' + windowWidth + '&h=' + windowHeight, function (data) {
		$.each(data, function(key, val) {
			var player = $('#' + key);
			
			if (player.attr('hash') != val.hash) {
				player.animate({
					'left': val.x + 'px',
					'top': val.y + 'px'
				}, 300);
				
				player.children('.player__name').animate({
					'font-size': val.font_size + 'em'
				}, 300);
				
				
				player.children('.player__image').animate({
					'height': val.image_height + 'px'
				}, 300);
				
				player.attr('hash', val.hash);
			}
		});
	});
}, 500);
