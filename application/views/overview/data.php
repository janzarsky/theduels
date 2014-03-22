<?php

$output = array();

$image_ratio = 21/36;

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
		$scale = 1;
	else
		$scale = 1 + 2*(($player['score'] - $score_mid)/$score_diff);
	
	$output['player' . $player['playerid']]['font_size'] = round($scale, 3);
	$output['player' . $player['playerid']]['image_height'] = round(($height/5)*$scale, 3);
	
	$skills['player' . $player['playerid']][$player['skill_id']] = $player['value'];
}

foreach ($skills as $id => $player_skills) {
	if (isset($player_skills['1']) && isset($player_skills['2']) && isset($player_skills['3'])) {
		$x = 0.5;
		$y = 0.5;
		$alpha = pi();
		
		$skill_max = max($player_skills['1'], $player_skills['2'], $player_skills['3']);
		$skill_min = min($player_skills['1'], $player_skills['2'], $player_skills['3']);
		$skill_diff = $skill_max - $skill_min;
		$skill_mid = $skill_min + $skill_diff/2;
		
		for ($i = 1; $i <= 3; $i++) {
			if ($skill_diff == 0)
				$value = 0;
			else {
				$value = 0 + 2*(($player_skills[$i]-$skill_mid)/$skill_diff);
				$value = ($value < 0) ? 0 : $value;
			}
			
			$dx = ($value/2)*0.8*sin($alpha);
			$dy = ($value/2)*0.8*cos($alpha);
			
			$x += $dx;
			$y += $dy;
			$alpha -= (2*pi())/3;
		}
		
		$absolute_x = round($width*$x - $output[$id]['image_height']*$image_ratio/2, 3);
		$absolute_y = round($height*$y - $output[$id]['image_height']/2, 3);
		
		$output[$id]['x'] = $absolute_x;
		$output[$id]['y'] = $absolute_y;
		
		$output[$id]['hash'] = md5($absolute_x . $absolute_y . $output[$id]['font_size'] . $output[$id]['image_height']);
	}
}

echo json_encode($output);