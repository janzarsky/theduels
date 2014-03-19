<aside class="players">
	<header class="players__header">
		Players
	</header>
	<ul class="players__list">
		<?php foreach ($players as $player): ?>
			<li class="players__list__item">
				<img src="/theduely/media/images/avatars/<?php echo $player['number']; ?>.png" height="32">
				<?php echo $player['name']; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="players__delete">
		<form action="deleteplayers_submit" method="post">
			<div class="players__delete__select">
				<select name="id">
					<?php	foreach ($players as $player) : ?>
						<option value="<?php echo $player['playerid']; ?>">
							<?php echo $player['name']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<input class="players__delete__submit" type="submit" value="Smazat">
		</form>
	</div>
</aside>

<div class="content">
	<form action="addplayers_submit" method="post">
		<div class="name">
			<header class="name__header">
				jméno
			</header>
			<input type="text" name="name">
		</div>
		
		<div class="avatar">
			<header class="avatar__header">
				avatar
			</header>
			<select class="avatar__select" name="avatar_id">
				<?php	foreach ($avatars as $avatar) : ?>
					<option class="avatar__select__option" value="<?php echo $avatar['id']; ?>">
						<?php echo $avatar['id']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="images">
			<?php	foreach ($avatars as $avatar) : ?>
				<div class="images__option" value="<?php echo $avatar['id']; ?>">
					<img src="/theduely/media/images/avatars/<?php echo $avatar['number']; ?>.png">
					<div class="images__id">
						<?php echo $avatar['id']; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<input class="submit" type="submit" value="Přidat">
	</form>
</div>