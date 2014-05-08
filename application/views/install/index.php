<div class="content">
	<header class="content__header">
		Instalace
	</header>
	
	<div class="main main--center">
		<form method="post" action="<?php echo base_url('install/db_setup_submit'); ?>">
			<div class="field">
				<header class="field__header">
					Server:
				</header>
				<input type="text" class="field__text" name="hostname">
			</div>
			
			<div class="field">
				<header class="field__header">
					Uživatel:
				</header>
				<input type="text" class="field__text" name="username">
			</div>
			
			<div class="field">
				<header class="field__header">
					Heslo:
				</header>
				<input type="password" class="field__text" name="password">
			</div>
			
			<div class="field">
				<header class="field__header">
					Databáze:
				</header>
				<input type="text" class="field__text" name="database">
			</div>
			
			<div class="field">
				<header class="field__header">
					Prefix:
				</header>
				<input type="text" class="field__text" name="prefix">
			</div>
			
			<input class="field__submit" type="submit" value="OK">
		</form>
	</div>
</div>