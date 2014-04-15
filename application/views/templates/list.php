<div class="content">
	<header class="content__header">
		<?php echo $header; ?>
	</header>
	
	<div class="main main--center">
		<ul class="list">
			<?php foreach ($items as $item): ?>
				<a href="<?php echo base_url($item['url']); ?>">
					<li class="list__item">
						<?php if (isset($item['image_url'])) : ?>
							<img src="<?php echo base_url($item['image_url']); ?>.png" height="48">
						<?php endif; ?>
						
						<?php echo $item['label']; ?>
					</li>
				</a>
			<?php endforeach; ?>
		</ul>
	</div>
</div>