<?php
class Login_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function is_password_right($password) {
		return ($password == $this->get_password());
	}
	
	private function get_password() {
		return $this->db
			->select('value')
			->from('settings')
			->where('name', 'password')
			->get()->row_array()['value'];
	}
}