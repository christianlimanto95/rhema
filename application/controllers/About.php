<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class About extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("About_model");
	}
	
	public function index()
	{
        parent::set_header_menu_active("about");
		$data = array(
            "title" => "Rhema Tours &mdash; About",
            "meta_description" => "Rhema Tours and Travel adalah sebuah biro perjalanan wisata yang didirikan atas dasar kerinduan untuk dapat melayani banyak peziarah untuk dapat beribadah di Yerusalem."
		);
		
		parent::view("about", $data);
	}
}
