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
		$this->db->where('id', $id);
			
		return $this->db->get()->row_array();
	}
}