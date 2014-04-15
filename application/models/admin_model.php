<?php
class Admin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_pages() {
		return array(
			array('label' => 'Správa hráčů', 'url' => '/admin/players'),
			array('label' => 'Zadávání duelů', 'url' => '/control'),
			array('label' => 'Přehled', 'url' => '/overview'),
			array('label' => 'Prohlížeč', 'url' => '/viewer')
		);
	}

	public function get_players()
	{
		return $this->db
			->select("`players`.`name` as label, CONCAT('/media/images/avatars/', `avatars`.`number` ) as image_url,
							 CONCAT('/viewer/', `players`.`id` ) as url, `players`.`id` as id", false)
			->from('players')
			->join('avatars', 'players.avatar_id = avatars.id', 'left')
			->order_by('name')
			->get()->result_array();
	}
	
	public function get_free_avatars()
	{
		return $this->db
			->select('*')
			->from('avatars')
			->where('free', '1')
			->get()->result_array();
	}
	
	public function add_player($name, $avatar_id)
	{
		$this->add_player_data($name, $avatar_id);
		
		$player_id = $this->db->insert_id();
		$this->add_player_skills($player_id);
		$this->add_player_achievements($player_id);
		
		$this->set_avatar_availability($avatar_id, 0);
	}
	
	private function add_player_data($name, $avatar_id) {
		$score = $this->get_skills_num() * 100;
		
		$players_data = array(
			'name' => $name,
			'avatar_id' => $avatar_id,
			'pure_score' => $score,
			'score' => $score,
			'bonus_score' => 0,
			'nick' => $this->get_nick($name)
		);
		
	$this->db->insert('players', $players_data);
	}
	
	private function get_skills_num() {
		return $this->db
			->select('id')
			->from('skills')
			->get()->num_rows();
	}
	
	private function add_player_skills($player_id) {
		$skills = $this->get_skills();
		
		foreach ($skills as $skill) {
			$players_skills_data[] = array(
				'player_id' => $player_id,
				'skill_id' => $skill['id'],
				'value' => 100
			);
		}
		
		$this->db->insert_batch('players_skills', $players_skills_data);
	}
	
	private function add_player_achievements($player_id) {
		for ($i = 1; $i <= 4; $i++) {
			$players_achievements_data[$i] = array(
				'player_id' => $player_id,
				'achievement_id' => $i,
				'level' => 0
			);
		}

		$this->db->insert_batch('players_achievements', $players_achievements_data);
	}
	
	private function set_avatar_availability($avatar_id, $available) {
		$this->db->update('avatars', array('free' => $available), array('id' => $avatar_id));
	}
	
	private function get_nick($name) {
		return str_replace(
			array('ě', 'é', 'ř', 'ť', 'ý', 'ú', 'ů', 'í', 'ó', 'á', 'š', 'ď', 'ž', 'č', 'ň'),
			array('e', 'e', 'r', 't', 'y', 'u', 'u', 'i', 'o', 'a', 's', 'd', 'z', 'c', 'n'),
			strtolower($name)
		);
	}
	
	public function delete_player($id)
	{
		try {
			$this->db->delete('players_skills', array('player_id' => $id));
			$this->db->delete('players_achievements', array('player_id' => $id));
			$this->db->delete('log_duels', array('player_1_id' => $id));
			$this->db->delete('log_duels', array('player_2_id' => $id));
			
			$avatar_id = $this->db->select('avatar_id')->from('players')->where('id', $id)->get()->row_array()['avatar_id'];
			$this->set_avatar_availability($avatar_id, 1);
			
			$this->db->delete('players', array('id' => $id));
		}
		catch (Exception $e) {
			throw new Exception('dberror');
		}
	}
}