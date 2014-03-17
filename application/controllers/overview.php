<?php

class Overview extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('overview_model');
	}

	public function index() {
		$html_header_data['title'] = 'Overview';
		$html_header_data['style'] = 'overview.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$overview_data['players'] = $this->overview_model->get_players();
		$this->load->view('overview/index', $overview_data);
		
		$html_footer_data['script'] = 'overview.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function data() {
		$overview_data['players_data'] = $this->overview_model->get_players_data();
		$this->load->view('overview/data', $overview_data);
	}
}