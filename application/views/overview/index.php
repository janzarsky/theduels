<div class="content">
	<?php foreach ($players as $player): ?>
		<div class="player" id="player<?php echo $player['playerid']; ?>">
			<img class="player__image" src="/theduely/media/images/avatars/<?php echo $player['number']; ?>.png">
			<div class="player__name">
				<?php echo $player['name']; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>