<nav class="menu">
	<a href="<?php echo base_url('/setup'); ?>">
		<span class="menu__item">
			Nastavení
		</span>
	</a>
	<a href="<?php echo base_url('/admin'); ?>">
		<span class="menu__item">
			Admin
		</span>
	</a>
	<a href="<?php echo base_url('/logout'); ?>">
		<span class="menu__item">
			Odhlásit se
		</span>
	</a>
	<?php if (isset($message)) : ?>
		<div class="menu__message <?php if (isset($message_type)) echo 'menu__message--' . $message_type; ?>">
			<?php echo $message; ?>
		</div>
	<?php endif; ?>
</nav>