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
		
		if ($this->db->select('*')->from('avatars')->get()->num_rows() == false) {
			foreach (explode(';',$sql) as $query)
				if (trim($query) != '')
					$this->db->query($query);
		}
		
		$sql = read_file('./application/achievements.sql');
		
		if ($this->db->select('*')->from('achievements')->get()->num_rows() == false) {
			foreach (explode(';',$sql) as $query)
				if (trim($query) != '')
					$this->db->query($query);
		}
		
		if ($this->db->select('*')->from('settings')->get()->num_rows() == false) {
			$this->db->insert('settings', array('name' => 'position_visible', 'label' => 'Zobrazení pořadí', 'value' => '1'));
			$this->db->insert('settings', array('name' => 'setup_lock', 'label' => 'Setup lock', 'value' => '0'));
			$this->db->insert('settings', array('name' => 'password', 'label' => 'Password', 'value' => 'admin'));
		}
	}
}
