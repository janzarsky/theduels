<?php
class Viewer_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function is_position_visible() {
		$visible = $this->db
			->select('value')
			->from('settings')
			->where('name', 'position_visible')
			->get()->row_array()['value'];
		
		return ($visible == 'true');
	}
	
	public function get_player($id = FALSE) {
		return $this->db
			->select('*, players.id as player_id')
			->from('players')
			->join('avatars', 'players.avatar_id = avatars.id', 'left')
			->where('players.id', $id)
			->get()->row_array();
	}
	
	public function get_players() {
		return $this->db
			->select('*, players.id as player_id')
			->from('players')
			->join('avatars', 'players.avatar_id = avatars.id', 'left')
			->order_by('name')
			->get()->result_array();
	}
	
	public function get_player_id($nick = FALSE) {
		return $this->db
			->select('id')
			->from('players')
			->where('nick', $nick)
			->get()->row_array()['id'];
	}
	
	public function get_player_position($id = FALSE) {
		$score = $this->db
			->select('score')
			->from('players')
			->where('id', $id)
			->get()->row_array()['score'];
		
		return $this->db->select('COUNT(*) as position')->from('players')->where('score >=', $score)->get()->row_array()['position'];
	}
	
	public function get_player_skills($id = FALSE)
	{
		return $this->db
			->select('*')
			->from('players_skills')
			->join('skills', 'players_skills.skill_id = skills.id')
			->where('player_id', $id)
			->order_by('skill_id', 'asc')
			->get()->result_array();
	}
	
	public function get_player_achievements($id = FALSE)
	{
		return $this->db
			->select('*')
			->from('players_achievements')
			->join('achievements', 'players_achievements.achievement_id = achievements.id')
			->where('player_id', $id)
			->order_by('achievement_id', 'asc')
			->get()->result_array();
	}
}