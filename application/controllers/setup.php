<?php

class Setup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('setup_model');
		$this->load->model('ip_model');
	}
	
	public function index() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'Nastavení';
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
			$this->ip_model->validate_ip();
			
			try {
				$this->setup_model->set_lock($this->input->post('lock'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function achievements() {
		try {
			$this->ip_model->validate_ip();
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
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->setup_model->set_achievements($this->input->post('id'), $this->input->post('state'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/achievements', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			$html_header_data['title'] = 'Skilly';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Skilly:';
			$data['items'] = $this->setup_model->get_skills_as_items();
			
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
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->setup_model->add_skill($this->input->post('name'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/skills', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->setup_model->delete_skill($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/skills', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			$html_header_data['title'] = 'Hry';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Hry:';
			$data['items'] = $this->setup_model->get_games();
			
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
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->setup_model->add_game($this->input->post('name'), $this->input->post('skill_id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/games', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->setup_model->delete_game($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/games', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	private function check_lock() {
		if ($this->setup_model->get_lock() == true)
			throw new Exception('Setup is locked');
	}
	
	private function redirect_with_message($url, $message) {
		if (isset($message) || $message != '')
			redirect(base_url($url) . '?message=' . $message);
		else
			redirect(base_url($url) . '?message=success');
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