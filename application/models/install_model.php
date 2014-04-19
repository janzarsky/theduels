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
		
		$sql = read_file('./application/avatars.sql');
		
		if ($this->db->select('*')->from('avatars')->get()->num_rows() == 0) {
			foreach (explode(';',$sql) as $query)
				if (trim($query) != '')
					$this->db->query($query);
		}
		
		if ($this->db->select('*')->from('settings')->get()->num_rows() == 0) {
			$this->db->insert('ip_whitelist', array('ip' => '127.0.0.1', 'name' => 'localhost'));
			$this->db->insert('settings', array('name' => 'position_visible', 'value' => 'true'));
			$this->db->insert('settings', array('name' => 'setup_lock', 'value' => 'false'));
			$this->db->insert('settings', array('name' => 'ip_whitelist_enabled', 'value' => 'false'));
			$this->db->insert('settings', array('name' => 'password', 'value' => 'admin'));
		}
	}
}