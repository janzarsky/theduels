<?php
class Overview_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function get_players()	{
		return $this->db
			->select('*, players.id as playerid')
			->from('players')
			->join('avatars', 'players.avatar_id = avatars.id', 'left')
			->order_by('score', 'asc')
			->get()->result_array();
	}
	
	public function get_data($width = 800, $height = 600) {
		$players_data = $this->get_players_data();
		
		$image_ratio = 21/36;
		
		$players_num = count($players_data);
		$number = $this->count_number_xy($width, $players_num);
		
		$size = ($height/$number['y'])/2;
		$max_size = $size*1.5;
		
		$score_stats = $this->count_score_stats($players_data);
		
		$output = array();
		
		$counter = 0;
		
		foreach ($players_data as $player) {
			$id = 'player' . $player['id'];
			
			$scale = $this->count_scale($player['score'], $score_stats);
			
			$font_size = round($scale, 3);
			$image_height = round($size*$scale);
			
			$output[$id]['font_size'] = $font_size;
			$output[$id]['image_height'] = $image_height;
			
			$x = $counter%$number['x'] + 1;
			$y = floor($counter/$number['x']) + 1;
			
			$x /= $number['x'] + 1;
			$y /= $number['y'] + 1;
			
			$absolute_x = round($width*$x - $output[$id]['image_height']/2);
			$absolute_y = round($height*$y - $output[$id]['image_height']/2);
			
			$output[$id]['x'] = $absolute_x;
			$output[$id]['y'] = $absolute_y;
			
			$output[$id]['hash'] = md5($absolute_x . $absolute_y . $font_size . $image_height);
			
			$counter++;
		}
		
		return $output;
	}
	
	private function get_players_data() {
		return $this->db
			->select('id, score')
			->from('players')
			->order_by('score', 'desc')
			->get()->result_array();
	}
	
	private function count_scale($score, $score_stats) {
		if ($score_stats['diff'] == 0)
				return 1;
			else
				return 1 + ($score - $score_stats['mid'])/$score_stats['diff'];
	}
	
	private function count_number_xy($width, $players_num) {
		$x = floor($width/200);
		$y = ceil($players_num/$x);
		
		return array(
			'x' => $x,
			'y' => $y
		);
	}
	
	private function count_score_stats($players_data) {
		$max = $players_data[0]['score'];
		$min = $players_data[0]['score'];
		
		foreach ($players_data as $player) {
			if ($player['score'] > $max)
				$max = $player['score'];
			else if ($player['score'] < $min)
				$min = $player['score'];
		}
		
		$diff = $max - $min;
		$mid = $min + $diff/2;
		
		return array(
			'mid' => $mid,
			'diff' => $diff
		);
	}
}