<div class="content">
	<header class="content__header">
		Přihlášení
	</header>
	
	<div class="main main--center">
		<form action="<?php echo base_url('login/submit'); ?>" method="post">
			<div class="field">
				<header class="field__header">
					Heslo:
				</header>
				<input class="field__text" type="password" name="password">
			</div>
			
			<input type="submit" class="field__submit" value="OK"/>
		</form>
	</div>
</div>