<?php
class Control_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_players()
	{
		$this->db->select('*');
		$this->db->from('players');
		$this->db->order_by('name');
			
		return $this->db->get()->result_array();
	}
	
	public function get_games()
	{
		$this->db->select('*');
		$this->db->from('games');
		$this->db->order_by('name');
			
		return $this->db->get()->result_array();
	}
	
	public function submit_duel($game_id, $player_1_id, $player_2_id, $score) {
		if ($player_1_id == $player_2_id)
			throw new Exception("players are the same");
		
		$skill_id = $this->get_skill_id($game_id);
		
		$player_1_skill = $this->get_skill($player_1_id, $skill_id);
		$player_2_skill = $this->get_skill($player_2_id, $skill_id);
		
		$expected_score_1 = $this->count_score($player_1_skill, $player_2_skill);
		$expected_score_2 = 1 - $expected_score_1;
		
		$score_1 = $score/2;
		$score_2 = 1 - $score/2;
		
		$k = 10;
		
		$player_1_skill += $k*($expected_score_1 - $score_1);
		$player_2_skill += $k*($expected_score_2 - $score_2);
		
		$this->update_skill($player_1_id, $skill_id, $player_1_skill);
		$this->update_skill($player_2_id, $skill_id, $player_2_skill);
		
		$this->log_duel($game_id, $player_1_id, $player_2_id, $score);
		
		$this->update_achievement_player($player_1_id);
		$this->update_achievement_player($player_2_id);
	}
	
	public function get_skill_id($game_id) {
		return $this->db->select('skill_id')->from('games')->where('id', $game_id)->get()->row_array()['skill_id'];
	}
	
	private function get_skill($player_id, $skill_id) {
		return $this->db->select('value')->from('players_skills')
			->where(array('player_id' => $player_id, 'skill_id' => $skill_id))->get()->row_array()['value'];
	}
	
	private function count_score($p1, $p2) {
		return 1/(1 + pow(10, ($p2 - $p1)/40));
	}
	
	private function update_skill($player_id, $skill_id, $skill_value) {
		$this->db->update('players_skills', array('value' => $skill_value), array('player_id' => $player_id, 'skill_id' => $skill_id));
		
		$score = $this->db->select_sum('value')->from('players_skills')->where('player_id', $player_id)->get()->row_array()['value'];
		$this->db->update('players', array('score' => $score), array('id' => $player_id));
	}
	
	private function log_duel($game_id, $player_1_id, $player_2_id, $score) {
		$data = array(
			'game_id' => $game_id,
			'player_1_id' => $player_1_id,
			'player_2_id' => $player_2_id,
			'score' => $score
		);
		
		$this->db->insert('log_duels', $data);
	}
	
	private function update_achievement_player($player_id) {
		$level = $this->db->select('level')->from('players_achievements')->where(array('player_id' => $player_id, 'achievement_id' => 2))
			->get()->row_array()['level'];
		
		if ($level == 3)
			return;
		
		$limit = $this->db->select('limit' . ($level + 1))->from('achievements')->where('id', 2)->get()->row_array()['limit' . ($level + 1)];
		
		$games = $this->db->select('id')->from('log_duels')->where(array('player_1_id' => $player_id))->get()->num_rows();
		$games += $this->db->select('id')->from('log_duels')->where(array('player_2_id' => $player_id))->get()->num_rows();
	
		if ($games >= $limit) {
			$level++;
			$this->db->update('players_achievements', array('level' => $level), array('player_id' => $player_id, 'achievement_id' => 2));
		}
	}
}