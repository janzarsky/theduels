<?php

class Install extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('install_model');
	}

	public function index() {
		$html_header_data['title'] = 'Admin';
		$html_header_data['style'] = 'list.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->install_model->create_db();
		
		$list_data['header'] = 'Installation';
		$list_data['items'] = array(
			array('label' => 'Database created!', 'url' => '/admin'),
			array('label' => 'Continue', 'url' => '/admin')
		);
		$this->load->view('templates/list', $list_data);
		
		$this->load->view('templates/html_footer');
	}
}