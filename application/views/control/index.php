<div class="content">
	<header class="content__header">
		<?php echo $game_name; ?>
	</header>
	
	<form action="<?php echo base_url('control/submit/' . $game_id); ?>" method="post">
		<input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
		
		<div class="field" id="player1">
			<header class="field__header">
				hráč 1
			</header>
			<select class="field__select" name="player_1_id" autofocus>
				<?php	foreach ($players as $player) : ?>
					<option class="field__select__option" value="<?php echo $player['id']; ?>">
						<?php echo $player['name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="field">
			<header class="field__header">
				skóre
			</header>
			<select class="field__select" name="score">
				<option class="field__select__option" value="2">
					2:0
				</option>
				<option class="field__select__option" value="1">
					1:1
				</option>
			</select>
		</div>
		
		<div class="field" id="player2">
			<header class="field__header">
				hráč 2
			</header>
			<select class="field__select" name="player_2_id">
				<?php	foreach ($players as $player) : ?>
					<option class="field__select__option" value="<?php echo $player['id']; ?>">
						<?php echo $player['name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<input type="submit" class="field__submit" value="OK"/>
	</form>
</div>