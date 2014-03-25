<?php
class Ip_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function is_ip_valid($ip) {
		return $this->db->select('*')->from('ip_whitelist')->where('ip', $ip)->get()->num_rows() > 0;
	}
}