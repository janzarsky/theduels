<?php
class Control_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_players()
	{
		$this->db->select('*');
		$this->db->from('players');
			
		return $this->db->get()->result_array();
	}
}