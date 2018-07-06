<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Contact extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Contact_model");
	}
	
	public function index()
	{
        parent::set_header_menu_active("contact");
		$data = array(
            "title" => "Rhema Tours &mdash; Contact Us",
            "meta_description" => "Contact Us | Life Changing Trip to The Holyland"
		);
		
		parent::view("contact", $data);
    }
    
    public function submit_message() {
        $name = $this->input->post("name");
        $email = $this->input->post("email");
        $phone = $this->input->post("phone");
        $subject = $this->input->post("subject");
        $message = $this->input->post("message");

        if ($name != "" && $email != "" && $phone != "") {
            $this->load->library("email", parent::get_default_email_config());

            $this->email->from("marketing.rhematours@gmail.com", "Rhema Tours");
            $this->email->to("marketing.rhematours@gmail.com");
            $this->email->subject("contact message");
            $this->email->message("Name : " . $name . "<br />Email : " . $email . "<br />Phone : " . $phone . "<br />Subject : " . $subject . "<br />Message : " . $message);
            $this->email->send();
        
            redirect(base_url("contact/thank_you"));
        } else {
            redirect(base_url("contact"));
        }
    }

    public function thank_you() {
        parent::set_header_menu_active("contact");
            $data = array(
                "title" => "Thank You &mdash; Rhema Tours"
            );
            
            parent::view("contact_thank_you", $data);
    }
}
