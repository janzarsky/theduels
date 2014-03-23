setInterval(function () {
	$.getJSON('data/' + id, function (data) {
		player = $('.player');
		
		if (player.attr('hash') != data.hash) {
			$('.player__score').text('Skóre: ' + data.score);
			
			$.each(data.skills, function(key, val) {
				$('#player__skills__bar' + val.skill_id).css('height', val.value + 'em');
				$('#player__skills__value' + val.skill_id).text(val.value);
			});
			
			player.attr('hash', data.hash);
		}
	});
}, 500);