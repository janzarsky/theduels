<?php
class Ip_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function validate_ip() {
		if ($this->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
			throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
	}
	
	private function is_ip_valid($ip) {
		return $this->db->select('*')->from('ip_whitelist')->where('ip', $ip)->get()->num_rows() > 0;
	}
}