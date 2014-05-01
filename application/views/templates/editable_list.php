<div class="content">
	<header class="content__header">
		<?php echo $header; ?>
	</header>
	
	<div class="main">
		<ul class="list">
			<?php foreach ($items as $item): ?>
				<li class="list__item">
					<?php if (isset($item['image_url'])) : ?>
						<img src="<?php echo base_url($item['image_url']); ?>.png" height="48">
					<?php endif; ?>
					
					<?php echo $item['label']; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="aside">
		<section class="section">
			<header class="section__header">
				Přidat
			</header>
			
			<?php echo $add; ?>
		</section>
		
		<section class="section">
			<header class="section__header">
				Smazat
			</header>
			
			<?php echo $delete; ?>
		</section>
	</div>
	
	<?php if (isset($url_back)): ?>
		<div class="footer">
			<a href="<?php echo base_url($url_back); ?>">
				<button class="button" type="button">
					Hotovo!
				</button>
			</a>
		</div>
	<?php endif; ?>
</div>