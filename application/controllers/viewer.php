<?php

class Viewer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('viewer_model');
	}

	public function index($id = '') {
		$html_header_data['title'] = 'Viewer';
		$html_header_data['style'] = 'viewer.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		if ($id !== '') {
			$viewer_data['player'] = $this->viewer_model->get_player($id);
			$viewer_data['player_skills'] = $this->viewer_model->get_player_skills($id);
			$this->load->view('viewer/index', $viewer_data);
		}
		
		$html_footer_data['script'] = 'viewer.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function data($id = '') {
		if (isset($id)) {
			$viewer_data['player'] = $this->viewer_model->get_player($id);
			$viewer_data['player_skills'] = $this->viewer_model->get_player_skills($id);
			
			$this->load->view('viewer/data', $viewer_data);
		}
	}
}