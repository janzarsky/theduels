<form action="<?php echo base_url('/setup/avatars_add_submit'); ?>" method="post" enctype="multipart/form-data">
	<div class="field">
		<header class="field__header">
			Obrázek:
		</header>
		<input type="file" class="field__file" name="file" >
	</div>
	
	<input class="field__submit" type="submit" value="Přidat">
</form>