<aside class="players">
	<header class="players__header">
		Players
	</header>
	<ul class="players__list">
		<?php foreach ($players as $player): ?>
			<li class="players__list__item">
				<img src="<?php echo base_url('/media/images/avatars/' . $player['number']); ?>.png" height="32">
				<?php echo $player['name']; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="players__delete">
		<form action="deleteplayers_submit" method="post">
			<div class="field">
				<header class="field__header">
					Hráč:
				</header>
				
				<select class="field__select" name="id">
					<?php	foreach ($players as $player) : ?>
						<option value="<?php echo $player['playerid']; ?>">
							<?php echo $player['name']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<input class="field__submit" type="submit" value="Smazat">
		</form>
	</div>
</aside>

<div class="content">
	<form action="addplayers_submit" method="post">
		<div class="field">
			<header class="field__header">
				jméno
			</header>
			<input class="field__text" type="text" name="name">
		</div>
		
		<div class="field">
			<header class="field__header">
				avatar
			</header>
			<select class="field__select" id="avatar__select" name="avatar_id">
				<?php	foreach ($avatars as $avatar) : ?>
					<option value="<?php echo $avatar['id']; ?>">
						<?php echo $avatar['id']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="images">
			<?php	foreach ($avatars as $avatar) : ?>
				<div class="images__option" value="<?php echo $avatar['id']; ?>">
					<img src="<?php echo base_url('/media/images/avatars/' . $avatar['number']); ?>.png">
					<div class="images__id">
						<?php echo $avatar['id']; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<input class="field__submit" type="submit" value="Přidat">
	</form>
</div>