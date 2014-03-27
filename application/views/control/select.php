<div class="games">
	<header class="games__header">
		Hry:
	</header>
	<ul class="games__list">
		<?php foreach ($games as $game): ?>
			<a href="<?php echo base_url('control/' . $game['id']); ?>">
				<li class="games__list__item">
					<?php echo $game['name']; ?>
				</li>
			</a>
		<?php endforeach; ?>
	</ul>
</div>