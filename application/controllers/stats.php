<?php

class Stats extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('stats_model');
	}

	public function index($game_id = false) {
		$html_header_data['title'] = 'Stats';
		$html_header_data['style'] = 'stats.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('templates/menu');
		
		$stats_data['players'] = $this->create_players_table();
		$this->load->view('stats/index', $stats_data);
		
		$this->load->view('templates/html_footer');
	}
	
	private function create_players_table() {
		foreach ($this->stats_model->get_players() as $player) {
			$table[$player['id']] = array('name' => $player['name']);
		}
		
		$skills_data = $this->stats_model->get_skills_data();
		
		foreach ($skills_data as $player_skills) {
			$table[$player_skills['player_id']]['skill_' . $player_skills['skill_id']] = $player_skills['value'];
		}
		
		$achievements_data = $this->stats_model->get_achievements_data();
		
		foreach ($achievements_data as $player_achievements) {
			$table[$player_achievements['player_id']]['achievement_' . $player_achievements['achievement_id']] = $player_achievements['level'];
		}
		
		return $table;
	}
}