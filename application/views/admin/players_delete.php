<form action="<?php echo base_url('/admin/players_delete_submit'); ?>" method="post">
	<div class="field">
		<header class="field__header">
			Hráč:
		</header>
		
		<select class="field__select" name="id">
			<?php	foreach ($items as $item) : ?>
				<option value="<?php echo $item['id']; ?>">
					<?php echo $item['label']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<input class="field__submit" type="submit" value="Smazat">
</form>