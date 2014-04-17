<?php
class Install_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('file');
	}
	
	public function create_db() {
		$sql = read_file('./application/theduels.sql');
		
		foreach (explode(';',$sql) as $query)
			if (trim($query) != '')
				$this->db->query($query);
		
		return $sql;
	}
}