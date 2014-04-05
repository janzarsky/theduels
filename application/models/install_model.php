<?php
class Install_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function create_db() {
		$sql = file_get_contents(base_url('/theduels.sql'));
		
		foreach (explode(';',$sql) as $query)
			if (trim($query) != '')
				$this->db->query($query);
		
		return $sql;
	}
}