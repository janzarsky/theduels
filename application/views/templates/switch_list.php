<div class="content">
	<header class="content__header">
		<?php echo $header; ?>
	</header>
	
	<div class="main main--center">
		<form action="<?php echo base_url($submit_url); ?>" method="post">
			<?php foreach ($items as $item): ?>
				<div class="field">
					<header class="field__header">
						<?php echo $item['label']; ?>
					</header>
					
					<select class="field__select" name="<?php echo $item['id']; ?>">
						<option value="1" <?php echo ($item['enabled']) ? 'selected="selected"' : ''; ?>>
							Zapnuto
						</option>
						<option value="0" <?php echo (!$item['enabled']) ? 'selected="selected"' : ''; ?>>
							Vypnuto
						</option>
					</select>
				</div>
			<?php endforeach; ?>
			
			<input class="field__submit" type="submit" value="Uložit">
		</form>
	</div>
</div>