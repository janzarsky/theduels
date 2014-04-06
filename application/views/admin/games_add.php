<form method="post" action="<?php echo base_url('admin/games_add_submit'); ?>">
	<div class="field">
		<header class="field__header">
			Jméno:
		</header>
		<input class="field__text" type="text" name="name">
	</div>
	
	<div class="field">
		<header class="field__header">
			Skill:
		</header>
		<select class="field__select" name="skill_id">
			<?php	foreach ($skills as $skill) : ?>
				<option value="<?php echo $skill['id']; ?>">
					<?php echo $skill['name']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<input class="field__submit" type="submit" value="Přidat">
</form>