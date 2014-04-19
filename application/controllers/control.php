<?php

class Control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('control_model');
	}

	public function index($game_id = false) {
		try {
			$this->check_login();
			
			if ($game_id === false) {
				$this->select();
				return;
			}
			
			$html_header_data['title'] = 'Control';
			$html_header_data['style'] = 'control.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$control_data['game_id'] = $game_id;
			$control_data['game_name'] = $this->control_model->get_game_name($game_id);
			$control_data['players'] = $this->control_model->get_players();
			$this->load->view('control/index', $control_data);
			
			$html_footer_data['script'] = 'control.js';
			$this->load->view('templates/html_footer', $html_footer_data);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function select() {
		try {
			$this->check_login();
			
			$html_header_data['title'] = 'Vyber hru';
			$html_header_data['style'] = 'list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$list_data['header'] = 'Hry:';
			$list_data['items'] = $this->control_model->get_games();
			$this->load->view('templates/list', $list_data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function submit($game_id = false) {
		try {
			$this->check_login();
			
			$this->control_model->submit_duel($this->input->post('game_id'), $this->input->post('player_1_id'),
																				$this->input->post('player_2_id'), $this->input->post('score'));
		}
		catch (Exception $e) {
			$this->session->set_flashdata('message', $e->getMessage());
			$this->session->set_flashdata('message_type', 'error');
		}
		
		if ($game_id === false)
			$url = '/control';
		else
			$url = '/control/' . $game_id;

		redirect(base_url($url));
	}
	
	private function check_login() {
		if ($this->session->userdata('logged_in') == false)
			redirect('login');
	}
	
	private function show_error_page($error) {
		$html_header_data['title'] = 'Chyba';
		$html_header_data['style'] = 'error.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('templates/menu');
		
		$data['message'] = $error->getMessage();
		$this->load->view('templates/error', $data);
		
		$this->load->view('templates/html_footer');
	}
}