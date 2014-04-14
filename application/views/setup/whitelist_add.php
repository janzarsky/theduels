<form method="post" action="<?php echo base_url('setup/whitelist_add_submit'); ?>">
	<div class="field">
		<header class="field__header">
			IP:
		</header>
		<input class="field__text" type="text" name="ip">
	</div>
	
	<div class="field">
		<header class="field__header">
			Jméno:
		</header>
		<input class="field__text" type="text" name="name">
	</div>
	
	<input class="field__submit" type="submit" value="Přidat">
</form>