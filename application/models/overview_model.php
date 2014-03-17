<?php
class Overview_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_players()
	{
		$this->db->select('*');
		$this->db->from('players');
		$this->db->order_by('score', 'asc');
			
		return $this->db->get()->result_array();
	}
	
	public function get_players_data()
	{
		$this->db->select('players.id, score, skill_id, value');
		$this->db->from('players');
		$this->db->join('players_skills', 'players_skills.player_id = players.id', 'left');
		$this->db->order_by('score', 'asc');
			
		return $this->db->get()->result_array();
	}
	
	public function get_skills()
	{
		$this->db->select('*');
		$this->db->from('skills');
			
		return $this->db->get()->result_array();
	}
}