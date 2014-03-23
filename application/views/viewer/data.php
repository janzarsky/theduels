<?php

$output = array();
$output['score'] = $player['score'];

foreach ($player_skills as $id => $skill) {
	$output['skills'][$id]['skill_id'] = $skill['id'];
	$output['skills'][$id]['value'] = $skill['value'];
}

$hash = md5(serialize($output));
$output['hash'] = $hash;

echo json_encode($output);