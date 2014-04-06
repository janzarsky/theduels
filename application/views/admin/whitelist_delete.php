<form method="post" action="<?php echo base_url('admin/whitelist_delete_submit'); ?>">
	<div class="field__header">
		Jméno:
	</div>
	<select class="field__select" name="id">
		<?php	foreach ($items as $item) : ?>
			<option value="<?php echo $item['id']; ?>">
				<?php echo $item['label']; ?>
			</option>
		<?php endforeach; ?>
	</select>
	
	<input class="field__submit" type="submit" value="Odebrat">
</form>