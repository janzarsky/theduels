<div class="content">
	<form action="control/submit" method="post">
		<div class="player" id="player1">
			<header class="player__header">
				player 1
			</header>
			<select class="player__select" name="player1" autofocus>
				<?php	foreach ($players as $player) : ?>
					<option class="player__select__option" value="<?php echo $player['id']; ?>">
						<?php echo $player['name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="score">
			<header class="score__header">
				score
			</header>
			<select class="score__select" name="score">
				<option class="score__select__option" value="2">
					2:0
				</option>
				<option class="score__select__option" value="1">
					1:1
				</option>
				<option class="score__select__option" value="0">
					0:2
				</option>
			</select>
		</div>
		
		<div class="player" id="player2">
			<header class="player__header">
				player 2
			</header>
			<select class="player__select" name="player2">
				<?php	foreach ($players as $player) : ?>
					<option class="player__select__option" value="<?php echo $player['id']; ?>">
						<?php echo $player['name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<input type="submit" class="submit" value="OK"/>
	</form>
</div>