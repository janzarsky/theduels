<?php

class Install extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
	}

	public function index() {
		$html_header_data['title'] = 'Admin';
		$html_header_data['style'] = 'install.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('install/index');
		
		$this->load->view('templates/html_footer');
	}
	
	public function db_setup_submit() {
		$config = read_file('./application/config/database-template.php');
		
		$config = str_replace('@hostname', $this->input->post('hostname'), $config);
		$config = str_replace('@username', $this->input->post('username'), $config);
		$config = str_replace('@password', $this->input->post('password'), $config);
		$config = str_replace('@database', $this->input->post('database'), $config);
		
		write_file('./application/config/database.php', $config);
		
		$this->load->model('install_model');
		
		$this->install_model->create_db();
		
		redirect('setup');
	}
}