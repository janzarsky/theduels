<div class="playerSelect" id="playerSelect1">
	<header class="playerSelect__header">
		Select player 1
	</header>
	<?php	foreach ($players as $player) : ?>
		<span class="playerSelect__player">
			<?php echo $player['name']; ?>
		</span>
	<?php endforeach; ?>
</div>

<div class="score">
	<header class="score__header">
		Set score
	</header>
	<div class="score__option">
		2:0
	</div>
	<div class="score__option">
		1:1
	</div>
	<div class="score__option">
		0:2
	</div>
</div>

<div class="playerSelect" id="playerSelect2">
	<header class="playerSelect__header">
		Select player 2
	</header>
	<?php	foreach ($players as $player) : ?>
		<span class="playerSelect__player">
			<?php echo $player['name']; ?>
		</span>
	<?php endforeach; ?>
</div>

<div class="submit">
	OK
</div>