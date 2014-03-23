setInterval(function () {
	$.getJSON('data/' + id, function (data) {
		player = $('.player');
		
		if (player.attr('hash') != data.hash) {
			$('.player__score').text('Skóre: ' + data.score);
			
			$.each(data.skills, function(key, val) {
				$('#player__skills__bar' + val.skill_id).css('height', val.value*2 + 'px');
				$('#player__skills__value' + val.skill_id).text(val.value);
			});
			
			$.each(data.achievements, function(key, val) {
				$('#player__achievements__icon' + val.achievement_id + ' img').attr('src', '/theduely/media/images/achievements/' + val.number + '-' + val.level + '.png');
			});
			
			player.attr('hash', data.hash);
		}
	});
}, 500);