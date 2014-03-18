<?php
class Viewer_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_player($id = FALSE)
	{
		$this->db->select('*');
		$this->db->from('players');
		$this->db->join('avatars', 'players.avatar_id = avatars.id', 'left');
		$this->db->where('players.id', $id);
			
		return $this->db->get()->row_array();
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
}