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
		$this->db->select("name as label, CONCAT('/control/', games.id ) as url");
		$this->db->from('games');
		$this->db->order_by('id');
			
		return $this->db->get()->result_array();
	}
	
	public function get_game_name($game_id) {
		return $this->db->select('name')->from('games')->where('id', $game_id)->get()->row_array()['name'];
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
		
		$player_1_skill_new = $player_1_skill + $k*($score_1 - $expected_score_1);
		$player_2_skill_new = $player_2_skill + $k*($score_2 - $expected_score_2);
		
		$this->update_skill($player_1_id, $skill_id, $player_1_skill_new);
		$this->update_skill($player_2_id, $skill_id, $player_2_skill_new);
		
		$this->log_duel($game_id, $player_1_id, $player_2_id, $score);
		
		$this->update_achievement_gamer($player_1_id);
		$this->update_achievement_gamer($player_2_id);
		
		if ($score_1 == 1) {
			$this->update_achievement_winner($player_1_id);
			$this->update_achievement_jumper($player_1_id, $player_1_skill, $player_2_skill);
			$this->update_achievement_skiller($player_1_id, $player_1_skill_new);
		}
		else if ($score_2 == 1) {
			$this->update_achievement_winner($player_2_id);
			$this->update_achievement_jumper($player_2_id, $player_2_skill, $player_1_skill);
			$this->update_achievement_skiller($player_2_id, $player_2_skill_new);
		}
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
		
		$pure_score = $this->db->select_sum('value')->from('players_skills')->where('player_id', $player_id)->get()->row_array()['value'];
		$this->db->update('players', array('pure_score' => $pure_score), array('id' => $player_id));
		
		$this->update_score($player_id);
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
	
	private function update_achievement_skiller($player_id, $skill_value) {
		$level = $this->get_achievement_level($player_id, 1);
		
		if ($level == 3)
			return;
		
		$limit = $this->get_achievement_limit(1, $level + 1);
		
		if ($skill_value >= $limit)
			$this->set_achievement_level($player_id, 1, $level+1);
	}
	
	private function update_achievement_gamer($player_id) {
		$level = $this->get_achievement_level($player_id, 2);
		
		if ($level == 3)
			return;
		
		$limit = $this->get_achievement_limit(2, $level + 1);
		
		$games = $this->db->select('id')->from('log_duels')->where(array('player_1_id' => $player_id))->get()->num_rows();
		$games += $this->db->select('id')->from('log_duels')->where(array('player_2_id' => $player_id))->get()->num_rows();
	
		if ($games >= $limit)
			$this->set_achievement_level($player_id, 2, $level+1);
	}
	
	private function update_achievement_winner($player_id) {
		$level = $this->get_achievement_level($player_id, 3);
		
		if ($level == 3)
			return;
		
		$limit = $this->get_achievement_limit(3, $level + 1);
		
		$r = $this->db->select('timestamp')->from('log_duels')->where(array('player_1_id' => $player_id, 'score' => 2))
			->order_by('timestamp', 'desc')->get();
			
		if ($r->num_rows() < $limit)
			return;
		
		$nth_win_time = $r->row_array($limit - 1)['timestamp'];
		
		$last_lose_time = $this->db->select('timestamp')->from('log_duels')->where(array('player_2_id' => $player_id, 'score' => 2))
			->order_by('timestamp', 'desc')->get()->row_array(0)['timestamp'];
		
		if ($last_lose_time < $nth_win_time)
			$this->set_achievement_level($player_id, 3, $level+1);
	}
	
	private function update_achievement_jumper($player_id, $skill_value_1, $skill_value_2) {
		if ($skill_value_1 >= $skill_value_2)
			return;
		
		$level = $this->get_achievement_level($player_id, 4);
		
		if ($level == 3)
			return;
		
		$limit = $this->get_achievement_limit(4, $level + 1);
		
		$diff = (($skill_value_2/$skill_value_1) - 1)*100;
		
		if ($diff >= $limit)
			$this->set_achievement_level($player_id, 4, $level+1);
	}
	
	private function get_achievement_level($player_id, $achievement_id) {
		return $this->db->select('level')->from('players_achievements')->where(array('player_id' => $player_id, 'achievement_id' => $achievement_id))
			->get()->row_array()['level'];
	}
	
	private function set_achievement_level($player_id, $achievement_id, $level) {
		$this->db->update('players_achievements', array('level' => $level), array('player_id' => $player_id, 'achievement_id' => $achievement_id));
		
		$this->update_bonus_score($player_id);
	}
	
	private function get_achievement_limit($achievement_id, $limit_num) {
		return $this->db->select('limit' . $limit_num)->from('achievements')->where('id', $achievement_id)->get()->row_array()['limit' . $limit_num];
	}
	
	private function update_bonus_score($player_id) {
		$level_1_count = $this->db->select('id')->from('players_achievements')
			->where(array('player_id' => $player_id, 'level' => 1))->get()->num_rows();
		
		$level_2_count = $this->db->select('id')->from('players_achievements')
			->where(array('player_id' => $player_id, 'level' => 2))->get()->num_rows();
		
		$level_3_count = $this->db->select('id')->from('players_achievements')
			->where(array('player_id' => $player_id, 'level' => 3))->get()->num_rows();
		
		$bonus_score = 3*$level_1_count + 5*$level_2_count + 10*$level_3_count;
		
		$this->db->update('players', array('bonus_score' => $bonus_score), array('id' => $player_id));
		
		$this->update_score($player_id);
	}
	
	private function update_score($player_id) {
		$result = $this->db->select('pure_score, bonus_score')->from('players')->where('id', $player_id)->get()->row_array();
		
		$score = $result['pure_score'] + $result['bonus_score'];
		
		$this->db->update('players', array('score' => $score), array('id' => $player_id));
	}
}