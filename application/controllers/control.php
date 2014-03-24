<?php

class Control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('control_model');
	}

	public function index($game_id = false) {
		$html_header_data['title'] = 'Control';
		$html_header_data['style'] = 'control.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		if ($game_id === false)
			$control_data['games'] = $this->control_model->get_games();
		else
			$control_data['game_id'] = $game_id;
		
		$control_data['players'] = $this->control_model->get_players();
		$this->load->view('control/index', $control_data);
		
		$html_footer_data['script'] = 'control.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function submit($game_id = false) {		
		try {
			$this->control_model->submit_duel($this->input->post('game_id'), $this->input->post('player_1_id'),
																				$this->input->post('player_2_id'), $this->input->post('score'));
		}
		catch (Exception $e) {
			$error_message .= $e->getMessage();
		}
		
		if ($game_id === false)
			$url = '/control';
		else
			$url = '/control/' . $game_id;
		
		if (isset($error_message))
			redirect(base_url($url . '?error=' . $error_message));
		else
			redirect(base_url($url));
	}
}