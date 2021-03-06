<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('login_model');
	}

	public function index() {
		if ($this->session->userdata('logged_in'))
			redirect('setup');
		
		$html_header_data['title'] = 'Login';
		$html_header_data['style'] = 'login.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('templates/menu');
		
		$this->load->view('login/index');
		
		$this->load->view('templates/html_footer');
	}
	
	public function submit() {
		if ($this->login_model->is_password_right($this->input->post('password'))) {
			$this->session->set_userdata('logged_in', '1');
			
			redirect('setup');
		}
		else {
			$this->session->set_flashdata('message', 'Špatné heslo');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('login');
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login');
	}
}