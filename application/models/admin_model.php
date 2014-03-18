<?php
class Admin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_players()
	{
		$this->db->select('*');
		$this->db->from('players');
		$this->db->join('avatars', 'avatars.id = players.avatar_id', 'left');
		$this->db->order_by('name');
			
		return $this->db->get()->result_array();
	}
	
	public function get_avatars()
	{
		$this->db->select('*');
		$this->db->from('avatars');
		$this->db->where('free', '1');
			
		return $this->db->get()->result_array();
	}
}