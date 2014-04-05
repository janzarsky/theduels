<?php
class Install_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function create_db() {
		$sql = file_get_contents('../theduels.sql');
		
		$this->db->query($sql);
	}
}