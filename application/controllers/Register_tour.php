<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Register_tour extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Register_tour_model");
	}
	
	public function index()
	{
        $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $month_value = $this->input->get("month");
        $year = $this->input->get("year");
        $tour = $this->input->get("tour");

        $month_text = "";
        $year_text = "";

        $page = $this->input->get("page");
        if ($page == null) {
            $page = 1;
        } else {
            $page = intval($page);
        }
        $view_per_page = 20;

        $count = 0;
        
        $tour_groups = null;
        if ($month_value != null) {
            $query = array(
                "month" => $month_value,
                "year" => $year,
                "tour" => trim($tour)
            );
            $tour_groups = $this->Register_tour_model->get_tour_group_query($query, $page, $view_per_page);
            $count = $this->Register_tour_model->get_tour_group_query_count($query)[0]->count;

            if ($month_value != "all") {
                $month_text = $month_name[intval($month_value)];
            } else {
                $month_text = "All";
            }

            if ($year != "all") {
                $year_text = $year;
            } else {
                $year_text = "All";
            }
        } else {
            $tour = "";
            $month_value = "all";
            $year = "all";
            $month_text = "All";
            $year_text = "All";
            $tour_groups = $this->Register_tour_model->get_tour_group($page, $view_per_page);
            $count = $this->Register_tour_model->get_tour_group_count()[0]->count;
        }
        $iLength = sizeof($tour_groups);
        for ($i = 0; $i < $iLength; $i++) {
            $date = $tour_groups[$i]->tg_tglStart;
            $date_item = explode("-", $date);
            $month = intval($date_item[1]);
            $tour_groups[$i]->tg_tglStartFormatted = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

            $date = $tour_groups[$i]->tg_tglEnd;
            $date_item = explode("-", $date);
            $month = intval($date_item[1]);
            $tour_groups[$i]->tg_tglEndFormatted = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
        }

        $page_count = ceil($count / $view_per_page);

        parent::set_header_menu_active("register_tour");
		$data = array(
            "title" => "Rhema Tours &mdash; Register Tour",
            "meta_description" => "Register Tour Here | Life Changing Trip to The Holyland",
            "data" => $tour_groups,
            "month" => $month_value,
            "month_text" => $month_text,
            "year" => $year,
            "year_text" => $year_text,
            "tour" => $tour,
            "page" => $page,
            "page_count" => $page_count
		);
		
		parent::view("register_tour", $data);
    }
    
    public function detail_tour_group() {
        $url_name = $this->uri->segment(3);
        $url_item = explode("-", $url_name);
        $id = $url_item[sizeof($url_item) - 1];

        $tour_group = $this->Register_tour_model->get_tour_group_by_id($id);
        if (sizeof($tour_group) > 0) {
            $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $day_name = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            $tour_group_itinerary = $this->Register_tour_model->get_tour_group_itinerary($id);
            $date = $tour_group[0]->tg_tglStart;
            if (trim($date) != "") {
                $date_item = explode("-", $date);
                $month = intval($date_item[1]);
                $tour_group[0]->tg_tglStart = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
            }

            $date = $tour_group[0]->tg_tglEnd;
            if (trim($date) != "") {
                $date_item = explode("-", $date);
                $month = intval($date_item[1]);
                $tour_group[0]->tg_tglEnd = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
            }

            $tour_group_highlight = $this->Register_tour_model->get_tour_group_highlight($id);
            $tour_group_bonus = $this->Register_tour_model->get_tour_group_bonus($id);

            $iLength = sizeof($tour_group_itinerary);
            for ($i = 0; $i < $iLength; $i++) {
                $dayofweek = date('w', strtotime($tour_group_itinerary[$i]->tgi_tanggal));
                $tour_group_itinerary[$i]->day = $day_name[$dayofweek];

                $date_item = explode("-", $tour_group_itinerary[$i]->tgi_tanggal);
                $month = intval($date_item[1]);
                $tour_group_itinerary[$i]->tgi_tanggal = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
            }

            parent::set_header_menu_active("register_tour");
            $data = array(
                "title" => $tour_group[0]->tg_nama . " &mdash; Rhema Tours",
                "meta_description" => $tour_group[0]->tg_rute . ". " . $tour_group[0]->tg_tglStart . " - " . $tour_group[0]->tg_tglEnd,
                "tour_group" => $tour_group[0],
                "tgi" => $tour_group_itinerary,
                "tghi" => $tour_group_highlight,
                "tgb" => $tour_group_bonus
            );
            
            parent::view("detail_tour_group", $data);
        } else {
            redirect(base_url("register-tour"));
        }
    }

    public function form() {
        $id = $this->uri->segment(3);
        $tour_group = $this->Register_tour_model->get_tour_group_by_id($id);
        if (sizeof($tour_group) > 0) {
            $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            $tour_group = $tour_group[0];
            $description = "";
            $tpd = array();
            $tpd_value = "";
            $tpd_text = "";

            if ($tour_group->tg_jenis == 1) {
                $date = $tour_group->tg_tglStart;
                $date_item = explode("-", $date);
                $month = intval($date_item[1]);
                $tour_group->tg_tglStart = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

                $date = $tour_group->tg_tglEnd;
                $date_item = explode("-", $date);
                $month = intval($date_item[1]);
                $tour_group->tg_tglEnd = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

                $description = "Form Pendaftaran Peserta Tour " . $tour_group->tg_nama . ". " . $tour_group->tg_tglStart . " - " . $tour_group->tg_tglEnd;
            } else {
                $description = "Form Pendaftaran Peserta " . $tour_group->tg_nama;
                $tpd = $this->Register_tour_model->get_tour_package_date($id);
                $iLength = sizeof($tpd);
                for ($i = 0; $i < $iLength; $i++) {
                    $date_item = explode("-", $tpd[$i]->tg_tglStart);
                    $month = intval($date_item[1]);
                    $tpd[$i]->tg_tglStart = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

                    $date_item = explode("-", $tpd[$i]->tg_tglEnd);
                    $month = intval($date_item[1]);
                    $tpd[$i]->tg_tglEnd = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];
                }

                $tpd_get = $this->input->get("tpd");
                if ($tpd_get != null) {
                    $ketemu = false;
                    for ($i = 0; $i < $iLength; $i++) {
                        if ($tpd[$i]->tpd_kode == $tpd_get) {
                            $tpd_value = $tpd[$i]->tpd_kode;
                            $tpd_text = $tpd[$i]->tg_tglStart . " - " . $tpd[$i]->tg_tglEnd;
                            break;
                        }
                    }
                } else {
                    $tpd_value = $tpd[0]->tpd_kode;
                    $tpd_text = $tpd[0]->tg_tglStart . " - " . $tpd[0]->tg_tglEnd;
                }
            }

            parent::set_header_menu_active("register_tour");
            $data = array(
                "title" => "Register Tour Form &mdash; " . $tour_group->tg_nama . " &mdash; Rhema Tours",
                "meta_description" => $description,
                "tour_group" => $tour_group,
                "tpd" => $tpd,
                "tpd_value" => $tpd_value,
                "tpd_text" => $tpd_text
            );
            
            parent::view("register_tour_form", $data);
        } else {
            redirect(base_url("tour-group/detail/" . $id));
        }
    }

    public function do_register_tour() {
        $tg_jenis = $this->input->post("tg_jenis", true);
        $tg_kode = $this->input->post("tg_kode", true);
        $tpd_kode = $this->input->post("tpd_kode", true);
        $tg_title = $this->input->post("tg_title", true);
        $tp_email = $this->input->post("tp_email", true);
        $tp_namaDepan = $this->input->post("tp_namaDepan", true);
        $tp_jenisKelamin = $this->input->post("tp_jenisKelamin", true);
        $tp_noHP_1 = $this->input->post("tp_noHP_1", true);

        if ($tg_kode && $tp_email && $tp_namaDepan && $tp_jenisKelamin && $tp_noHP_1) {
            $data = array(
                "tg_jenis" => $tg_jenis,
                "tg_kode" => $tg_kode,
                "tpd_kode" => $tpd_kode,
                "tp_email" => $tp_email,
                "tp_namaDepan" => $tp_namaDepan,
                "tp_jenisKelamin" => $tp_jenisKelamin,
                "tp_noHP_1" => $tp_noHP_1
            );
            $affected_rows = $this->Register_tour_model->insert_tour_peserta($data);

            $this->load->library("email", parent::get_default_email_config());

            $this->email->from("marketing.rhematours@gmail.com", "Rhema Tours");
            $this->email->to($tp_email);
            $this->email->subject("Thank You");
            $this->email->message("Terima kasih telah melakukan pendaftaran. <br />Data Anda akan kami proses dan Anda akan kami hubungi <br />dalam 1x24 jam <br /><br /><br />Regards, <br />Rhema Tours");
            $this->email->send();

            $this->session->set_flashdata("tg_title", $tg_title);
            redirect(base_url("register-tour/thank-you"));
        } else {
            redirect(base_url("register-tour/form/" . $tg_kode));
        }
    }

    public function thank_you() {
        $tg_title = $this->session->userdata("tg_title");

        if ($tg_title) {
            parent::set_header_menu_active("register_tour");
            $data = array(
                "title" => "Thank You &mdash; Rhema Tours",
                "tg_title" => $tg_title
            );
            
            parent::view("register_tour_thank_you", $data);
        } else {
            redirect(base_url("register-tour"));
        }
    }
}
