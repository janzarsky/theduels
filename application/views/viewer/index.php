<section class="player">
	<header class="player__name"><?php echo $player['name']; ?></header>
	<div class="player__score"><?php echo $player['score']; ?></div>
	<div class="player__skills">
		<div class="player__skills__power"><?php echo $player['skill_power']; ?></div>
		<div class="player__skills__mind"><?php echo $player['skill_mind']; ?></div>
		<div class="player__skills__magic"><?php echo $player['skill_magic']; ?></div>
	</div>
</section>