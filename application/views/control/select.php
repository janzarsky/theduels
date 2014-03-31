<div class="list">
	<header class="list__header">
		Hry:
	</header>
	<ul class="list__list">
		<?php foreach ($games as $game): ?>
			<a href="<?php echo base_url('control/' . $game['id']); ?>">
				<li class="list__list__item">
					<?php echo $game['name']; ?>
				</li>
			</a>
		<?php endforeach; ?>
	</ul>
</div>