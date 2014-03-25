<section class="player">
	<div class="player__info">
		<header class="player__name"><?php echo $player['name']; ?></header>
		<div class="player__image">
			<img src="/theduely/media/images/avatars/<?php echo $player['number']; ?>.png">
		</div>
		<div class="player__score">
			Skóre: <?php echo $player['score']; ?>
		</div>
		
		<div class="player__position">
			<?php if (isset($player_position)) : ?>
				Pořadí: <?php echo $player_position; ?>.
			<?php endif; ?>
		</div>
	</div>
	
	<div class="player__achievements">
		<?php foreach ($player_achievements as $achievement): ?>
			<span class="player__achievements__icon" id="player__achievements__icon<?php echo $achievement['achievement_id'];?>">
				<img src="/theduely/media/images/achievements/<?php echo $achievement['number'] . '-' . $achievement['level']; ?>.png">
			</span>
		<?php endforeach; ?>
	</div>
	
	<div class="player__skills">
		<table>
			<tbody>
				<tr class="player__skills__bars">
					<?php foreach ($player_skills as $skill): ?>
						<td><div class="player__skills__bar" id="player__skills__bar<?php echo $skill['skill_id'];?>"
							style="height: <?php echo $skill['value']*2; ?>px"></div></td>
					<?php endforeach; ?>
				</tr>
				<tr class="player__skills__values">
					<?php foreach ($player_skills as $skill): ?>
						<td><div class="player__skills__value" id="player__skills__value<?php echo $skill['skill_id'];?>"><?php echo $skill['value']; ?></div></td>
					<?php endforeach; ?>
				</tr>
				<tr class="player__skills__labels">
					<?php foreach ($player_skills as $skill): ?>
						<td><div class="player__skills__label" id="player__skills__label<?php echo $skill['skill_id'];?>"><?php echo $skill['name']; ?></div></td>
					<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<script>
	var id = <?php echo $player['player_id']; ?>;
	var url = '<?php echo base_url('viewer/data'); ?>';
</script>