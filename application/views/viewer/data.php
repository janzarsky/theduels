<?php

$output = array();
$output['score'] = $player['score'];

if (isset($player_position))
	$output['position'] = $player_position;

foreach ($player_skills as $id => $skill) {
	$output['skills'][$id]['skill_id'] = $skill['id'];
	$output['skills'][$id]['value'] = $skill['value'];
}

foreach ($player_achievements as $id => $achievement) {
	$output['achievements'][$id]['achievement_id'] = $achievement['id'];
	$output['achievements'][$id]['number'] = $achievement['number'];
	$output['achievements'][$id]['level'] = $achievement['level'];
}

$hash = md5(serialize($output));
$output['hash'] = $hash;

echo json_encode($output);