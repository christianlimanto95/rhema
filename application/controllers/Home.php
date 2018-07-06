<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Home extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Home_model");
	}
	
	public function index()
	{
        $carousel = $this->Home_model->get_carousel();
        $tour_groups = $this->Home_model->get_tour_group();
        $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $iLength = sizeof($tour_groups);
        for ($i = 0; $i < $iLength; $i++) {
            $date = $tour_groups[$i]->tg_tglStart;
            $date_item = explode("-", $date);
            $month = intval($date_item[1]);
            $tour_groups[$i]->tg_tglStart = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

            $date = $tour_groups[$i]->tg_tglEnd;
            $date_item = explode("-", $date);
            $month = intval($date_item[1]);
            $tour_groups[$i]->tg_tglEnd = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
        }

        $tour_packages = $this->Home_model->get_tour_package();
        parent::set_header_menu_active("home");
		$data = array(
            "title" => "Rhema Tours",
            "meta_description" => "Life Changing Trip to The Holyland",
            "carousel" => $carousel,
            "tour_packages" => $tour_packages,
            "tour_groups" => $tour_groups
		);
		
		parent::view("home", $data);
	}
}
