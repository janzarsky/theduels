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
	<?php if ($this->session->flashdata('message') != false): ?>
		<div class="menu__message
			<?php if ($this->session->flashdata('message_type') != false)
				echo 'menu__message--' . $this->session->flashdata('message_type'); ?>">
			<?php echo $this->session->flashdata('message'); ?>
		</div>
	<?php endif; ?>
</nav>