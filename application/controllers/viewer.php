<?php

class Viewer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->model('song_model');
	}

	public function index() {
		$html_header_data['title'] = 'Viewer';
		$html_header_data['style'] = 'viewer.css';
		$html_footer_data['script'] = 'viewer.js';
	
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('viewer/index');
		
		$this->load->view('templates/html_footer', $html_footer_data);
	}
}