<?php

class Viewer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('viewer_model');
	}

	public function index($id = false) {
		if ($id === false) {
			$this->select();
			return;
		}
		
		$html_header_data['title'] = 'Prohlížeč';
		$html_header_data['style'] = 'viewer.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$viewer_data['player'] = $this->viewer_model->get_player($id);
		
		if ($this->viewer_model->is_position_visible())
			$viewer_data['player_position'] = $this->viewer_model->get_player_position($id);
			
		$viewer_data['player_skills'] = $this->viewer_model->get_player_skills($id);
		$viewer_data['player_achievements'] = $this->viewer_model->get_player_achievements($id);
		$this->load->view('viewer/index', $viewer_data);
		
		$html_footer_data['script'] = 'viewer.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function select() {
		$html_header_data['title'] = 'Vyber hráče';
		$html_header_data['style'] = 'select.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$viewer_data['players'] = $this->viewer_model->get_players();
		$this->load->view('viewer/select', $viewer_data);
		
		$this->load->view('templates/html_footer');
	}
	
	public function player($name = false) {
		if ($name !== false) {
			$id = $this->viewer_model->get_player_id($name);
			$this->index($id);
		}
	}
	
	public function data($id = '') {
		if (isset($id)) {
			$viewer_data['player'] = $this->viewer_model->get_player($id);
			
			if ($this->viewer_model->is_position_visible())
				$viewer_data['player_position'] = $this->viewer_model->get_player_position($id);
			
			$viewer_data['player_skills'] = $this->viewer_model->get_player_skills($id);
			$viewer_data['player_achievements'] = $this->viewer_model->get_player_achievements($id);
			
			$this->load->view('viewer/data', $viewer_data);
		}
	}
}