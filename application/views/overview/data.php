<?php

$output = array();

$score_max = $players_data[0]['score'];
$score_min = $players_data[0]['score'];

foreach ($players_data as $player) {
	if ($player['score'] > $score_max)
		$score_max = $player['score'];
	else if ($player['score'] < $score_min)
		$score_min = $player['score'];
}

$score_diff = $score_max - $score_min;
$score_mid = $score_min + $score_diff/2;

foreach ($players_data as $player) {
	if ($score_diff == 0)
		$output['player' . $player['playerid']]['scale'] = 1;
	else
		$output['player' . $player['playerid']]['scale'] = 1 + ($player['score'] - $score_mid)/$score_diff;
	
	$skills['player' . $player['playerid']][$player['skill_id']] = $player['value'];
}

foreach ($skills as $id => $player_skills) {
	if (isset($player_skills['1']) && isset($player_skills['2']) && isset($player_skills['3'])) {
		$x = 0.5;
		$y = 0.5;
		$alpha = pi();
		
		$skill_max = max($player_skills['1'], $player_skills['2'], $player_skills['3']);
		$skill_min = min($player_skills['1'], $player_skills['2'], $player_skills['3']);
		$skill_mid = $skill_min + ($skill_max - $skill_min)/2;
		
		for ($i = 1; $i <= 3; $i++) {
			$diff = ($skill_max - $skill_mid);
			
			if ($diff == 0)
				$value = 0;
			else {
				$value = 0.5 + (($player_skills[$i]-$skill_mid)/$diff)/4;
				$value = ($value > 0.5) ? 0.5 : $value;
				$value = ($value < 0) ? 0 : $value;
			}
			
			$dx = $value * sin($alpha);
			$dy = $value * cos($alpha);
			
			$x += $dx;
			$y += $dy;
			$alpha -= (2*pi())/3;
		}
		
		$output[$id]['x'] = round($x, 3);
		$output[$id]['y'] = round($y, 3);
	}
}

echo json_encode($output);