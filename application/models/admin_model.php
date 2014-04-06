<?php
class Admin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_pages() {
		return array(
			array('label' => 'Správa hráčů', 'url' => '/admin/players'),
			array('label' => 'IP whitelist', 'url' => '/admin/whitelist'),
			array('label' => 'Zadávání duelů', 'url' => '/control'),
			array('label' => 'Přehled', 'url' => '/overview'),
			array('label' => 'Prohlížeč', 'url' => '/viewer')
		);
	}
	
	public function get_players()
	{
		return $this->db
			->select("`players`.`name` as label, CONCAT('/media/images/avatars/', `avatars`.`number` ) as image_url,
							 CONCAT('/viewer/', `players`.`id` ) as url, `players`.`id` as id", false)
			->from('players')
			->join('avatars', 'players.avatar_id = avatars.id', 'left')
			->order_by('name')
			->get()->result_array();
	}
	
	public function get_free_avatars()
	{
		return $this->db
			->select('*')
			->from('avatars')
			->where('free', '1')
			->get()->result_array();
	}
	
	public function add_player($name, $avatar_id)
	{
		$this->add_player_data($name, $avatar_id);
		
		$player_id = $this->db->insert_id();
		$this->add_player_skills($player_id);
		$this->add_player_achievements($player_id);
		
		$this->set_avatar_availability($avatar_id, 0);
	}
	
	private function add_player_data($name, $avatar_id) {
		$players_data = array(
			'name' => $name,
			'avatar_id' => $avatar_id,
			'pure_score' => 300,
			'nick' => $this->get_nick($name)
		);
		
	$this->db->insert('players', $players_data);
	}
	
	private function add_player_skills($player_id) {
		for ($i = 1; $i <= 3; $i++) {
			$players_skills_data[$i] = array(
				'player_id' => $player_id,
				'skill_id' => $i,
				'value' => 100
			);
		}
		
		$this->db->insert_batch('players_skills', $players_skills_data);
	}
	
	private function add_player_achievements($player_id) {
		for ($i = 1; $i <= 4; $i++) {
			$players_achievements_data[$i] = array(
				'player_id' => $player_id,
				'achievement_id' => $i,
				'level' => 0
			);
		}

		$this->db->insert_batch('players_achievements', $players_achievements_data);
	}
	
	private function set_avatar_availability($avatar_id, $available) {
		$this->db->update('avatars', array('free' => $available), array('id' => $avatar_id));
	}
	
	private function get_nick($name) {
		return str_replace(
			array('ě', 'é', 'ř', 'ť', 'ý', 'ú', 'ů', 'í', 'ó', 'á', 'š', 'ď', 'ž', 'č', 'ň'),
			array('e', 'e', 'r', 't', 'y', 'u', 'u', 'i', 'o', 'a', 's', 'd', 'z', 'c', 'n'),
			strtolower($name)
		);
	}
	
	public function delete_player($id)
	{
		try {
			$this->db->delete('players_skills', array('player_id' => $id));
			$this->db->delete('players_achievements', array('player_id' => $id));
			$this->db->delete('log_duels', array('player_1_id' => $id));
			$this->db->delete('log_duels', array('player_2_id' => $id));
			
			$avatar_id = $this->db->select('avatar_id')->from('players')->where('id', $id)->get()->row_array()['avatar_id'];
			$this->set_avatar_availability($avatar_id, 1);
			
			$this->db->delete('players', array('id' => $id));
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
	}
	
	public function get_ips() {
		return $this->db
			->select("CONCAT(`name`, ' (', `ip`, ')') as label, id as id", false)
			->from('ip_whitelist')
			->get()->result_array();
	}
	
	public function add_ip($ip = false, $name = false) {
		if ($ip === false || $name === false)
			throw new Exception('empty');
		
		$data = array(
			'ip' => $ip,
			'name' => $name
		);
		
		$this->db->insert('ip_whitelist', $data);
	}
	
	public function delete_ip($id = false) {
		if ($id === false)
			throw new Exception('empty');
		
		$this->db->delete('ip_whitelist', array('id' => $id));
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
		
		$this->db->delete('games', array('id' => $id));
	}
}