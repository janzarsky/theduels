<?php
class Admin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_players()
	{
		$this->db->select('*, players.id as playerid');
		$this->db->from('players');
		$this->db->join('avatars', 'avatars.id = players.avatar_id', 'left');
		$this->db->order_by('name');
			
		return $this->db->get()->result_array();
	}
	
	public function get_avatars()
	{
		$this->db->select('*');
		$this->db->from('avatars');
		$this->db->where('free', '1');
			
		return $this->db->get()->result_array();
	}
	
	public function add_player($name, $avatar_id)
	{
		$players_data = array(
			'name' => $name,
			'avatar_id' => $avatar_id
		);
		
		try {
			$this->db->insert('players', $players_data);
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
		
		for ($i = 1; $i <= 3; $i++) {
			$players_skills_data[$i] = array(
				'player_id' => $this->db->insert_id(),
				'skill_id' => $i,
				'value' => 100
			);
		}
		
		try {
			$this->db->insert_batch('players_skills', $players_skills_data);
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
		
		try {
			$this->db->update('avatars', array('free' => 0), array('id' => $avatar_id));
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
	}
	
	public function delete_player($id)
	{
		try {
			$this->db->delete('players_skills', array('player_id' => $id));
			$this->db->delete('log_duels', array('player_1_id' => $id));
			$this->db->delete('log_duels', array('player_2_id' => $id));
			
			$this->db->select('avatar_id')->from('players')->where('id', $id);
			$avatar_id = $this->db->get()->row_array()['avatar_id'];
			
			$this->db->update('avatars', array('free' => 1), array('id' => $avatar_id));
			
			$this->db->delete('players', array('id' => $id));
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
	}
}