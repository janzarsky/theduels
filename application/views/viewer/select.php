<div class="players">
	<header class="players__header">
		Players
	</header>
	<ul class="players__list">
		<?php foreach ($players as $player): ?>
			<a href="<?php echo base_url('viewer/' . $player['player_id']); ?>">
				<li class="players__list__item">
					<img src="/theduely/media/images/avatars/<?php echo $player['number']; ?>.png" height="48">
					<?php echo $player['name']; ?>
				</li>
			</a>
		<?php endforeach; ?>
	</ul>
</div>