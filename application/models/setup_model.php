<?php

class Setup_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_pages() {
		return array(
			array('label' => 'Skilly', 'url' => '/setup/skills'),
			array('label' => 'Disciplíny', 'url' => '/setup/games'),
			array('label' => 'Achievementy', 'url' => '/setup/achievements'),
			array('label' => 'Avataři', 'url' => '/setup/avatars')
		);
	}
	
	public function get_lock() {
		return $this->db
			->select('value')
			->from('settings')
			->where('name', 'setup_lock')
			->get()->row_array()['value'];
	}
	
	public function set_lock($state) {
		if (isset($state)) {
			$this->db->update('settings', array('value' => $state), array('name' => 'setup_lock'));
			
			$this->remove_data();
		}
	}
	
	private function remove_data() {
		$this->db->empty_table('players_achievements');
		$this->db->empty_table('players_skills');
		$this->db->empty_table('players');
		$this->db->empty_table('log_duels');
		
		$this->db->update('avatars', array('free' => '1'));
	}
	
	public function get_achievements() {
		return $this->db
			->select('id as id, enabled as enabled, name as label')
			->from('achievements')
			->get()->result_array();
	}
	
	public function set_achievements($ids, $states) {
		foreach ($ids as $key => $id) {
			$data[] = array('id' => $id, 'enabled' => $states[$key]);
		}
		
		$this->db->update_batch('achievements', $data, 'id');
	}
	
	public function is_there_any_skills() {
		return $this->db
			->select('id')
			->from('skills')
			->get()->num_rows() > 0;
	}
	
	public function get_skills_as_items() {
		return $this->db
			->select('name as label, id as id')
			->from('skills')
			->get()->result_array();
	}
	
	public function add_skill($name = false) {
		if ($name === false)
			throw new Exception('empty');
		
		$data = array(
			'name' => $name
		);
		
		$this->db->insert('skills', $data);
	}
	
	public function delete_skill($id = false) {
		if ($id === false)
			throw new Exception('empty');
		
		$this->db->delete('games', array('skill_id' => $id));
		$this->db->delete('skills', array('id' => $id));
	}
	
	public function get_games() {
		return $this->db
			->select("CONCAT(`games`.`name`, ' (', `skills`.`name`, ')') as label, `games`.`id` as id", false)
			->join("skills", "skills.id = games.skill_id")
			->from('games')
			->get()->result_array();
	}
	
	public function get_skills() {
		return $this->db
			->select('id, name')
			->from('skills')
			->get()->result_array();
	}
	
	public function add_game($name = false, $skill_id = false) {
		if ($name === false || $skill_id === false)
			throw new Exception('empty');
		
		$data = array(
			'name' => $name,
			'skill_id' => $skill_id
		);
		
		$this->db->insert('games', $data);
	}
	
	public function delete_game($id = false) {
		if ($id === false)
			throw new Exception('empty');
		
		$this->db->delete('log_duels', array('game_id' => $id));
		$this->db->delete('games', array('id' => $id));
	}
	
	public function get_avatars() {
		return $this->db
			->select("CONCAT('media/images/avatars/', `id`) as image_url, id as label, id as id", false)
			->from('avatars')
			->get()->result_array();
	}
	
	public function add_avatar($file = false) {
		if ($file === false)
			throw new Exception('Nebyl zvolen žádný soubor');
		
		if ($file["error"] > 0)
			throw new Exception('Chyba při posílání souboru');
		
		$extension = end(explode(".", $file["name"]));
		
		if (($file["type"] != "image/png") || ($extension != 'png'))
			throw new Exception('Soubor musí být formátu png');
		
		if ($file["size"] > 1048576)
			throw new Exception('Soubor je příliš velký. Maximální povolená velikost je 1MB');
		
		$this->db->insert('avatars', array('free' => '1'));
		
		$filename = "media/images/avatars/" . $this->db->insert_id() . ".png";
		
		move_uploaded_file($file["tmp_name"], $filename);
		
		$this->resize_image($filename);
	}
	
	private function resize_image($filename) {
		$max_width = 480;
		$max_height = 800;
		
		list($width, $height) = getimagesize($filename);
		
		$ratio = $width/$height;
		
		if ($max_width/$max_height > $ratio) {
			$new_width = $max_height*$ratio;
			$new_height = $max_height;
		} else {
			$new_width = $max_width;
			$new_height = $max_width/$ratio;
		}
		
		$thumb = imagecreatetruecolor($new_width, $new_height);
		$source = imagecreatefrompng($filename);
		
		imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
		imagealphablending($thumb, false);
		imagesavealpha($thumb, true);
		
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		imagepng($thumb, $filename);
	}
	
	public function delete_avatar($id = false) {
		if ($id === false)
			throw new Exception('empty');
		
		$this->db->delete('avatars', array('id' => $id));
		
		unlink('media/images/avatars/' . $id . '.png');
	}
}