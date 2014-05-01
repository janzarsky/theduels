<?php

class Setup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('setup_model');
	}
	
	public function index() {
		try {
			$this->check_login();
			
			$html_header_data['title'] = 'Pravidla';
			$html_header_data['style'] = 'setup.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['items'] = $this->setup_model->get_pages();
			$data['locked'] = $this->setup_model->get_lock();
			$this->load->view('setup/index', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function lock_submit() {
		try {
			$this->check_login();
			
			try {
				$this->setup_model->set_lock($this->input->post('lock'));
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function achievements() {
		try {
			$this->check_login();
			$this->check_lock();
			
			$html_header_data['title'] = 'Achievementy';
			$html_header_data['style'] = 'switch_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Achievementy:';
			$data['items'] = $this->setup_model->get_achievements();
			$data['submit_url'] = 'setup/achievements_submit';
			$this->load->view('templates/switch_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function achievements_submit() {
		try {
			$this->check_login();
			$this->check_lock();
			
			try {
				$this->setup_model->set_achievements($this->input->post('id'), $this->input->post('state'));
				
				$this->session->set_flashdata('message', 'Achievementy uloženy');
				$this->session->set_flashdata('message_type', 'success');
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills() {
		try {
			$this->check_login();
			$this->check_lock();
			
			$html_header_data['title'] = 'Skilly';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Skilly:';
			$data['items'] = $this->setup_model->get_skills_as_items();
			$data['url_back'] = 'setup';
			
			$data['add'] = $this->load->view('setup/skills_add', null, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'setup/skills_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_add_submit() {
		try {
			$this->check_login();
			$this->check_lock();
			
			try {
				$this->setup_model->add_skill($this->input->post('name'));
				
				$this->session->set_flashdata('message', 'Skill přidán');
				$this->session->set_flashdata('message_type', 'success');
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup/skills');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_delete_submit() {
		try {
			$this->check_login();
			$this->check_lock();
			
			try {
				$this->setup_model->delete_skill($this->input->post('id'));
				
				$this->session->set_flashdata('message', 'Skill odebrán');
				$this->session->set_flashdata('message_type', 'success');
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup/skills');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games() {
		try {
			$this->check_login();
			$this->check_lock();
			
			$html_header_data['title'] = 'Disciplíny:';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Disciplíny:';
			$data['items'] = $this->setup_model->get_games();
			$data['url_back'] = 'setup';
			
			$add_data['skills'] = $this->setup_model->get_skills();
			$data['add'] = $this->load->view('setup/games_add', $add_data, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'setup/games_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_add_submit() {
		try {
			$this->check_login();
			$this->check_lock();
			
			try {
				$this->setup_model->add_game($this->input->post('name'), $this->input->post('skill_id'));
				
				$this->session->set_flashdata('message', 'Disciplína přidána');
				$this->session->set_flashdata('message_type', 'success');
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup/games');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_delete_submit() {
		try {
			$this->check_login();
			$this->check_lock();
			
			try {
				$this->setup_model->delete_game($this->input->post('id'));
				
				$this->session->set_flashdata('message', 'Disciplína odebrána');
				$this->session->set_flashdata('message_type', 'success');
			}
			catch (Exception $e) {
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
			}
			
			redirect('setup/games');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	private function check_login() {
		if ($this->session->userdata('logged_in') == false)
			redirect('login');
	}
	
	private function check_lock() {
		if ($this->setup_model->get_lock() == true)
			throw new Exception('Pravidla jsou zamčena!');
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