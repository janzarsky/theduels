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
		<form method="post" action="<?php echo base_url($add_url); ?>">
			<div class="field__header">
				IP:
			</div>
			<input class="field__text" type="text" name="ip">
				
			<div class="field__header">
				Jméno:
			</div>
			<input class="field__text" type="text" name="name">
			
			<input class="field__submit" type="submit" value="Přidat">
		</form>
	</section>
	
	<section class="delete">
		<form method="post" action="<?php echo base_url($delete_url); ?>">
			<div class="field__header">
				Jméno:
			</div>
			<select class="field__select" name="id">
				<?php	foreach ($items as $item) : ?>
					<option value="<?php echo $item['id']; ?>">
						<?php echo $item['label']; ?>
					</option>
				<?php endforeach; ?>
			</select>
			
			<input class="field__submit" type="submit" value="Odebrat">
		</form>
	</section>
</div>