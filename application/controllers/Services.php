<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Services extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Services_model");
	}
	
	public function index()
	{
        $services = $this->Services_model->get_services();
        parent::set_header_menu_active("services");
		$data = array(
            "title" => "Rhema Tours &mdash; Services",
            "meta_description" => "See Our Services | Life Changing Trip to The Holyland",
            "data" => $services
		);
		
		parent::view("services", $data);
	}
}
