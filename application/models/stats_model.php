<?php
class Stats_model extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_players() {
		return $this->db
			->select('name, id')
			->from('players')
			->order_by('name')
			->get()->result_array();
	}
	
	public function get_skills() {
		return $this->db
			->select('name, id')
			->from('skills')
			->order_by('name')
			->get()->result_array();
	}
	
	public function get_skills_data() {
		return $this->db
			->select('players.id as player_id, players_skills.skill_id, players_skills.value')
			->from('players')
			->join('players_skills', 'players_skills.player_id = players.id')
			->order_by('players.name')
			->get()->result_array();
	}
	
	public function get_skills_names() {
		return $this->db
			->select('id, name')
			->from('skills')
			->get()->result_array();
	}
	
	public function get_achievements_data() {
		return $this->db
			->select('players.id as player_id, players_achievements.achievement_id, players_achievements.level')
			->from('players')
			->join('players_achievements', 'players_achievements.player_id = players.id')
			->join('achievements', 'achievements.id = players_achievements.achievement_id')
			->where('achievements.enabled', '1')
			->order_by('players.name')
			->get()->result_array();
	}
	
	public function get_achievements_names() {
		return $this->db
			->select('id, name')
			->from('achievements')
			->where('enabled', '1')
			->get()->result_array();
	}
}