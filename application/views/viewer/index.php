<section class="player">
	<div class="player__skills">
		<div class="player__skills__bar" style="height: <?php echo $player['skill_power']; ?>em">&nbsp;</div>
		<div class="player__skills__label"><?php echo $player['skill_power']; ?></div>
		<div class="player__skills__bar" style="height: <?php echo $player['skill_mind']; ?>em">&nbsp;</div>
		<div class="player__skills__label"><?php echo $player['skill_mind']; ?></div>
		<div class="player__skills__bar" style="height: <?php echo $player['skill_magic']; ?>em">&nbsp;</div>
		<div class="player__skills__label"><?php echo $player['skill_magic']; ?></div>
	</div>
	<header class="player__name"><?php echo $player['name']; ?></header>
	<div class="player__score"><?php echo $player['score']; ?></div>
</section>