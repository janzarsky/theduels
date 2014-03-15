<section class="player">
	<div class="player__info">
		<header class="player__name"><?php echo $player['name']; ?></header>
		<div class="player__image"></div>
		<div class="player__score">Skóre: <?php echo $player['score']; ?></div>
	</div>
	
	<div class="player__skills">
		<table>
			<tbody>
				<tr class="player__skills__bars">
					<td><div class="player__skills__bar" style="height: <?php echo $player['skill_power']; ?>em"></div></td>
					<td><div class="player__skills__bar" style="height: <?php echo $player['skill_mind']; ?>em"></div></td>
					<td><div class="player__skills__bar" style="height: <?php echo $player['skill_magic']; ?>em"></div></td>
				</tr>
				<tr class="player__skills__values">
					<td><div class="player__skills__value"><?php echo $player['skill_power']; ?></div></td>
					<td><div class="player__skills__value"><?php echo $player['skill_mind']; ?></div></td>
					<td><div class="player__skills__value"><?php echo $player['skill_magic']; ?></div></td>
				</tr>
				<tr class="player__skills__labels">
					<td><div class="player__skills__label">síla</div></td>
					<td><div class="player__skills__label">mysl</div></td>
					<td><div class="player__skills__label">magie</div></td>
				</tr>
			</tbody>
		</table>
	</div>
</section>