<div class="content">
	<?php foreach ($players as $player): ?>
		<a href="<?php echo base_url('viewer/' . $player['playerid']); ?>">
			<div class="player" id="player<?php echo $player['playerid']; ?>">
				<img class="player__image" src="/theduely/media/images/avatars/<?php echo $player['number']; ?>.png">
				<div class="player__name">
					<?php echo $player['name']; ?>
				</div>
		</div>
		</a>
	<?php endforeach; ?>
</div>

<script>
	var url = '<?php echo base_url('overview/data'); ?>';
</script>