<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Login extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Login_model");
	}
	
	public function index()
	{
		$data = array(
			"title" => "Rhema Tours &mdash; Login"
		);
		
		$this->load->view("login", $data);
    }
    
    public function do_login() {
		parent::show_404_if_not_ajax();
		$username = $this->input->post("username", true);
		$password = $this->input->post("password", true);
		if ($username != "" && $password != "") {
			$data = $this->Login_model->get_data($username);
			if (sizeof($data) > 0) {
				if (password_verify($password, $data[0]->admin_password)) {
					$this->session->set_userdata("user_id", $data[0]->admin_id);

					echo json_encode(array(
						"status" => "success"
					));
				} else {
					echo json_encode(array(
						"status" => "error"
					));
				}
			} else {
				echo json_encode(array(
					"status" => "error"
				));
			}
		} else {
			echo json_encode(array(
				"status" => "error"
			));
		}
    }
    
    public function logout() {
		$this->session->unset_userdata("user_id");
		redirect(base_url("login"));
	}
}
