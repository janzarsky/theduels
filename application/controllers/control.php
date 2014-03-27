<?php

class Control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('control_model');
		$this->load->model('ip_model');
	}

	public function index($game_id = false) {
		if ($game_id === false) {
			$this->select();
			return;
		}
		
		$html_header_data['title'] = 'Control';
		$html_header_data['style'] = 'control.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$control_data['game_id'] = $game_id;
		$control_data['game_name'] = $this->control_model->get_game_name($game_id);
		$control_data['players'] = $this->control_model->get_players();
		$this->load->view('control/index', $control_data);
		
		$html_footer_data['script'] = 'control.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function select() {
		$html_header_data['title'] = 'Vyber hru';
		$html_header_data['style'] = 'control_select.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$control_data['games'] = $this->control_model->get_games();
		$this->load->view('control/select', $control_data);
		
		$this->load->view('templates/html_footer');
	}
	
	public function submit($game_id = false) {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
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