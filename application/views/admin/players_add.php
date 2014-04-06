<form action="<?php echo base_url('/admin/players_add_submit'); ?>" method="post">
	<div class="field">
		<header class="field__header">
			Jméno:
		</header>
		<input class="field__text" type="text" name="name">
	</div>
	
	<div class="field">
		<header class="field__header">
			Avatar:
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