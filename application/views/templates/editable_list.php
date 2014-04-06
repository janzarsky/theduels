<div class="list">
	<header class="list__header">
		<?php echo $header; ?>
	</header>
	<ul class="list__list">
		<?php foreach ($items as $item): ?>
			<a href="<?php echo base_url($item['url']); ?>">
				<li class="list__list__item">
					<?php if (isset($item['image_url'])) : ?>
						<img src="<?php echo base_url($item['image_url']); ?>.png" height="48">
					<?php endif; ?>
					
					<?php echo $item['label']; ?>
				</li>
			</a>
		<?php endforeach; ?>
		
		<li class="list_list_add">
			<form method="post">
				<div class="form__fieldheader">IP:</div>
				<input type="text" name="ip">
				<div class="form__fieldheader">Jméno:</div>
				<input type="text" name="name">
				<input type="submit" value="Přidat">
			</form>
		</li>
	</ul>
</div>