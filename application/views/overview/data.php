<?php

$output = array();

foreach ($players_data as $player) {
	$output['player' . $player['id']]['scale'] = $player['score']/1000;
	
	$skills['player' . $player['id']][$player['skill_id']] = $player['value'];
}

foreach ($skills as $id => $player_skills) {
	if (isset($player_skills['1']) && isset($player_skills['2']) && isset($player_skills['3'])) {
		$x = 0.5;
		$y = 0.5;
		$alpha = pi();
		
		for ($i = 1; $i <= 3; $i++) {
			$value = $player_skills[$i]/200;
			$value = ($value > 1) ? 1 : $value;
			
			$dx = $value * sin($alpha);
			$dy = $value * cos($alpha);
			
			$x += $dx;
			$y += $dy;
			$alpha -= (2*pi())/3;
		}
		
		$output[$id]['x'] = $x;
		$output[$id]['y'] = $y;
	}
}

echo json_encode($output);