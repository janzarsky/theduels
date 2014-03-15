<?php

class Control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('control_model');
	}

	public function index() {
		$html_header_data['title'] = 'Control';
		$html_header_data['style'] = 'control.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$control_data['players'] = $this->control_model->get_players();
		$this->load->view('control/index', $control_data);
		
		$html_footer_data['script'] = 'control.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
}