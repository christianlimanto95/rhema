<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Tour_packages extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Tour_packages_model");
	}
	
	public function index()
	{
        $tour_packages = $this->Tour_packages_model->get_tour_package();
        parent::set_header_menu_active("tour_packages");
		$data = array(
            "title" => "Rhema Tours &mdash; Tour Packages",
            "meta_description" => "See Our Tour Packages | Life Changing Trip to The Holyland",
            "data" => $tour_packages
		);
		
		parent::view("tour_packages", $data);
    }
    
    public function detail() {
        $url_name = $this->uri->segment(3);
        $url_item = explode("-", $url_name);
        $id = $url_item[sizeof($url_item) - 1];
        $tour_package = $this->Tour_packages_model->get_tour_package_by_id($id);
        if (sizeof($tour_package) > 0) {
            $tpd_kode = $this->input->get("tpd");
            $tpd_kode_get = "";
            if ($tpd_kode != null) {
                $tpd_kode_get = "?tpd=" . $tpd_kode;
            }

            $tour_package = $tour_package[0];
            $tgi = $this->Tour_packages_model->get_tour_package_itinerary($id);
            $tghi = $this->Tour_packages_model->get_tour_package_highlight($id);
            $tgb = $this->Tour_packages_model->get_tour_package_bonus($id);

            parent::set_header_menu_active("tour_packages");
            $data = array(
                "title" => $tour_package->tg_nama . " &mdash; Rhema Tours",
                "meta_description" => $tour_package->tg_description . " &mdash; Rhema Tours",
                "tour_package" => $tour_package,
                "tgi" => $tgi,
                "tghi" => $tghi,
                "tgb" => $tgb,
                "tpd_kode_get" => $tpd_kode_get
            );
            
            parent::view("tour_packages_detail", $data);
        } else {
            redirect(base_url("tour-packages"));
        }
    }
}
