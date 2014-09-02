<div class="content">
	<header class="content__header">
		Stats
	</header>
	
	<div class="main main--wide">
		<table>
			<tr>
				<?php foreach ($table_head as $title): ?>
					<th><?php echo $title;?></th>
				<?php endforeach; ?>
			</tr>
			<?php foreach ($table as $row_id => $row): ?>
				<tr>
					<?php foreach ($row as $cell_id => $cell): ?>
						<?php if ($cell_id == 'name'): ?>
							<td>
								<a href="<?php echo base_url('viewer/' . $row_id); ?>">
									<?php echo $cell; ?>
								</a>
							</td>
						<?php else: ?>
							<td>
								<?php echo $cell; ?>
							</td>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>