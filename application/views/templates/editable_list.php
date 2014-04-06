<div class="content">
	<header class="content__header">
		<?php echo $header; ?>
	</header>
	
	<section class="list">
		<ul class="list__list">
			<?php foreach ($items as $item): ?>
				<li class="list__list__item">
					<?php if (isset($item['image_url'])) : ?>
						<img src="<?php echo base_url($item['image_url']); ?>.png" height="48">
					<?php endif; ?>
					
					<?php echo $item['label']; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	
	<section class="add">
		<?php echo $add; ?>
	</section>
	
	<section class="delete">
		<?php echo $delete; ?>
	</section>
</div>