<form method="post" action="<?php echo base_url('admin/whitelist_add_submit'); ?>">
	<div class="field__header">
		IP:
	</div>
	<input class="field__text" type="text" name="ip">
		
	<div class="field__header">
		Jméno:
	</div>
	<input class="field__text" type="text" name="name">
	
	<input class="field__submit" type="submit" value="Přidat">
</form>