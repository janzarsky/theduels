<div class="content">
	<header class="content__header">
		Změnit heslo
	</header>
	
	<div class="main main--center">
		<form action="<?php echo base_url('admin/password_submit'); ?>" method="post">
			<div class="field">
				<header class="field__header">
					Nové heslo:
				</header>
				<input type="password" class="field__text" name="password">
			</div>
			
			<input type="submit" class="field__submit" value="OK"/>
		</form>
	</div>
</div>