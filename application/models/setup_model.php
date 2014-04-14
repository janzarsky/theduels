<?php

class Setup_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
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
}