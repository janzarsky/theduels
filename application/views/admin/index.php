<div class="content">
	<header class="content__header">
		Admin
	</header>
	
	<?php foreach ($stages as $stage): ?>
		<section class="list">
			<header class="list__header">
				<?php echo $stage['header']; ?>
			</header>
			
			<ul class="list__list">
				<?php foreach ($stage['items'] as $item): ?>
					<a href="<?php echo base_url($item['url']); ?>">
						<li class="list__list__item">
							<?php echo $item['label']; ?>
						</li>
					</a>
				<?php endforeach; ?>
			</ul>
			
			<form method="post" action="<?php echo base_url('admin/lock_submit'); ?>">
				<input type="hidden" name="lock" value="<?php echo ($stage['locked']) ? 0 : 1; ?>">
				
				<input class="field__submit" type="submit" value="<?php echo ($stage['locked']) ? 'Odemknout' : 'Zamknout'; ?>">
			</form>
		</section>
	<?php endforeach; ?>
</div>