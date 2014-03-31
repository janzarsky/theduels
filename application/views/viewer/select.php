<div class="list">
	<header class="list__header">
		Hráči:
	</header>
	<ul class="list__list">
		<?php foreach ($players as $player): ?>
			<a href="<?php echo base_url('/viewer/' . $player['player_id']); ?>">
				<li class="list__list__item">
					<img src="<?php echo base_url('/media/images/avatars/' . $player['number']); ?>.png" height="48">
					<?php echo $player['name']; ?>
				</li>
			</a>
		<?php endforeach; ?>
	</ul>
</div>