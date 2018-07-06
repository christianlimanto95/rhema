<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
NOTE
Just put general function which frequently used in this class
**/

class General_controller extends CI_Controller
{
    protected $header_menu = array(
        "home" => "",
        "register_tour" => "",
        "services" => "",
        "tour_packages" => "",
        "article" => "",
        "about" => "",
        "contact_us" => ""
    );

    protected $admin_menu_active = array(
        "home" => "",
        "carousel" => "",
        "tour_highlight" => "",
        "tour_bonus" => "",
        "tour_group" => "",
        "tour_package" => "",
        "article" => "",
        "services" => "",
        "about" => ""
    );
    
    protected $script_count = 0;
    protected $additional_files = "";
    protected $additional_css = "";
    protected $additional_js = "";
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common/General_model');
    }

	public function load_module($module_name) {
		$this->load_additional_css($module_name);
		$this->load_additional_js($module_name);
	}
	
	public function load_additional_css($file_name) {
		$this->additional_css .= "<link href='" . base_url("assets/css/common/" . $file_name . ".css") . "' rel='stylesheet'>";
	}
	
	public function load_additional_js($file_name) {
        $this->script_count++;
		$this->additional_js .= "<script onload='script" . $this->script_count . "onload()' src='" . base_url("assets/js/common/" . $file_name . ".js") . "' defer></script>";
    }
    
    public function set_header_menu_active($name) {
        $this->header_menu[$name] = " active";
    }

    public function view($file, $data){
        $data["additional_css"] = $this->additional_css;
        $data["additional_js"] = $this->additional_js;
        $data["page_name"] = $file;
        $data["header_menu"] = $this->header_menu;
		
        $this->load->view('common/header', $data);
        $this->load->view($file, $data);
        $this->load->view('common/footer');
    }

	public function adminview($file, $data){
        $data["additional_css"] = $this->additional_css;
        $data["additional_js"] = $this->additional_js;
		$data["page_name"] = $file;
		
        $this->load->view('common/adminheader', $data);
        $this->load->view($file, $data);
        $this->load->view('common/adminfooter');
    }

    public function redirect_if_not_logged_in() {
        if (!$this->session->userdata('user_id', true)) {
            redirect(base_url("login"));
        }
    }
    
    public function is_logged_in() {
        return $this->session->userdata('user_id', true);
	}

    function show_404_if_not_ajax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
            return true;
        } else {
            show_404();
        }
    }

    public function upload_file_settings($path = '', $max_size = '', $file_name = "") {
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $config['max_size'] = $max_size;
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['encrypt_name'] = false;
        $config['max_width'] = '';
        $config['max_height'] = '';
        if ($file_name != "") {
            $config["file_name"] = $file_name;
        }
        $this->load->library('upload', $config);
    }

    public function get_default_email_config() {
        $config["protocol"] = "smtp";
		/*$config["smtp_host"] = "rhema.dnp-project.com";
		$config["smtp_user"] = "admin@rhema.dnp-project.com";
        $config["smtp_pass"] = "admin";*/
        $config["smtp_host"] = "ssl://smtp.googlemail.com";
		$config["smtp_user"] = "marketing.rhematours@gmail.com";
		$config["smtp_pass"] = "rhema123";
		$config["smtp_port"] = 465;
        $config["smtp_crypto"] = "ssl";
        $config["mailtype"] = "html";
        return $config;
    }

    public function set_admin_menu_active($menu) {
        $this->admin_menu_active[$menu] = " active";
        return $this->admin_menu_active;
    }
}