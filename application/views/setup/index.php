<div class="content">
	<header class="content__header">
		Pravidla
	</header>
	
	<div class="main main--center">
		<ul class="list">
			<?php foreach ($items as $item): ?>
				<?php if ($locked): ?>
					<li class="list__item list__item--unavailable">
						<?php echo $item['label']; ?>
					</li>
				<?php else: ?>
				<a href="<?php echo base_url($item['url']); ?>">
					<li class="list__item">
						<?php echo $item['label']; ?>
					</li>
				</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		
		<form method="post" action="<?php echo base_url('setup/lock_submit'); ?>">
			<input type="hidden" name="lock" value="<?php echo ($locked) ? 0 : 1; ?>">
			
			<input class="field__submit" type="submit" value="<?php echo ($locked) ? 'Odemknout' : 'Zamknout'; ?>">
		</form>
	</div>
</div>