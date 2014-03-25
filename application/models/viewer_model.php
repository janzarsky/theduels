<?php
class Viewer_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_player($id = FALSE)
	{
		$this->db->select('*, players.id as player_id');
		$this->db->from('players');
		$this->db->join('avatars', 'players.avatar_id = avatars.id', 'left');
		$this->db->where('players.id', $id);
			
		return $this->db->get()->row_array();
	}
	
	public function get_player_id($nick = FALSE) {
		return $this->db->select('id')->from('players')->where('nick', $nick)->get()->row_array()['id'];
	}
	
	public function get_player_position($id = FALSE) {
		$score = $this->db->select('score')->from('players')->where('id', $id)->get()->row_array()['score'];
		
		return $this->db->select('COUNT(*) as position')->from('players')->where('score >=', $score)->get()->row_array()['position'];
	}
	
	public function get_player_skills($id = FALSE)
	{
		$this->db->select('*');
		$this->db->from('players_skills');
		$this->db->join('skills', 'players_skills.skill_id = skills.id');
		$this->db->where('player_id', $id);
		$this->db->order_by('skill_id', 'asc');
		
		return $this->db->get()->result_array();
	}
	
	public function get_player_achievements($id = FALSE)
	{
		$this->db->select('*');
		$this->db->from('players_achievements');
		$this->db->join('achievements', 'players_achievements.achievement_id = achievements.id');
		$this->db->where('player_id', $id);
		$this->db->order_by('achievement_id', 'asc');
		
		return $this->db->get()->result_array();
	}
}