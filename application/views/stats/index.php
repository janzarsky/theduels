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
			<?php foreach ($table as $row): ?>
				<tr>
					<?php foreach ($row as $cell): ?>
						<td><?php echo $cell;?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>