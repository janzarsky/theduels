<?php

class Setup_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_pages() {
		return array(
			array('label' => 'Skilly', 'url' => '/setup/skills'),
			array('label' => 'Hry', 'url' => '/setup/games'),
			array('label' => 'Achievementy', 'url' => '/setup/achievements'),
			array('label' => 'IP whitelist', 'url' => '/setup/whitelist')
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
		if (isset($state))
			$this->db->update('settings', array('value' => $state), array('name' => 'setup_lock'));
	}
	
	public function get_achievements() {
		return $this->db
			->select('id as id, enabled as enabled, name as label')
			->from('achievements')
			->get()->result_array();
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
}