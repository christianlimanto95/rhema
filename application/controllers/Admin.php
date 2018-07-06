<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Admin extends General_controller {
	public function __construct() {
        parent::__construct();
        parent::redirect_if_not_logged_in();
		$this->load->model("Admin_model");
	}
	
	public function index()
	{
        $month_name = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $page = $this->input->get("page");
        if ($page == null) {
            $page = 1;
        } else {
            $page = intval($page);
        }
        $view_per_page = 20;
        $offset = ($page - 1) * $view_per_page;

        $tour_peserta = $this->Admin_model->get_tour_peserta($offset, $view_per_page);
        $iLength = sizeof($tour_peserta);
        for ($i = 0; $i < $iLength; $i++) {
            $date_item = explode("-", $tour_peserta[$i]->tg_tglStart);
            $month = intval($date_item[1]);
            $tour_peserta[$i]->tg_tglStart = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

            $date_item = explode("-", $tour_peserta[$i]->tg_tglEnd);
            $month = intval($date_item[1]);
            $tour_peserta[$i]->tg_tglEnd = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0];

            $datetime = explode(" ", $tour_peserta[$i]->created_date);
            $date_item = explode("-", $datetime[0]);
            $month = intval($date_item[1]);
            $tour_peserta[$i]->created_date = $date_item[2] . " " . $month_name[$month] . " " . $date_item[0] . " " . $datetime[1];
        }

        $total_rows = $this->Admin_model->get_page_count($view_per_page)[0]->count;
        $decimal = $total_rows / $view_per_page;
        $page_count = ceil($decimal);

		$data = array(
			"title" => "Admin &mdash; Home",
			"menu_active" => parent::set_admin_menu_active("home"),
            "menu_title" => "Home",
            "tp" => $tour_peserta,
            "page" => $page,
            "page_count" => $page_count
		);
		
		parent::adminview("admin", $data);
    }

    public function follow_up_tour_peserta() {
        $tp_kodePeserta = $this->input->post("tp_kodePeserta", true);
        $user_id = parent::is_logged_in();
        if ($tp_kodePeserta) {
            $data = array(
                "tp_kodePeserta" => $tp_kodePeserta,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->follow_up_tour_peserta($data);
            if ($affected_rows > 0) {
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
    }

    public function carousel() {
        $carousel = $this->Admin_model->get_carousel();
		$data = array(
			"title" => "Admin &mdash; Carousel",
			"menu_active" => parent::set_admin_menu_active("carousel"),
            "menu_title" => "Carousel",
            "data" => $carousel
		);
		
		parent::adminview("admin_carousel", $data);
    }

    public function carousel_insert() {
        $carousel_text_position = $this->input->post("carousel_text_position");
        $carousel_title = trim($this->input->post("carousel_title"));
        $carousel_title_color = $this->input->post("carousel_title_color");
        $carousel_description = trim($this->input->post("carousel_description"));
        $carousel_description_color = $this->input->post("carousel_description_color");
        $carousel_button_color = $this->input->post("carousel_button_color");
        $carousel_button_text = $this->input->post("carousel_button_text");
        $carousel_button_link = $this->input->post("carousel_button_link");
        $carousel_image = $this->input->post("carousel_image");
        $carousel_image_mobile = $this->input->post("carousel_image_mobile");
        $carousel_zoom_out = $this->input->post("carousel_zoom_out");
        $carousel_index = $this->input->post("carousel_index");

        $carousel_image_extension = "";
        if ($carousel_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $carousel_image_extension = $type;
            }
        }

        $carousel_image_mobile_extension = "";
        if ($carousel_image_mobile != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image_mobile, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $carousel_image_mobile_extension = $type;
            }
        }

        if ($carousel_text_position && $carousel_title_color) {
            $data = array(
                "carousel_text_position" => $carousel_text_position,
                "carousel_title" => $carousel_title,
                "carousel_title_color" => $carousel_title_color,
                "carousel_description" => $carousel_description,
                "carousel_description_color" => $carousel_description_color,
                "carousel_button_color" => $carousel_button_color,
                "carousel_button_text" => $carousel_button_text,
                "carousel_button_link" => $carousel_button_link,
                "carousel_image_extension" => $carousel_image_extension,
                "carousel_image_mobile_extension" => $carousel_image_mobile_extension,
                "carousel_zoom_out" => $carousel_zoom_out,
                "carousel_index" => $carousel_index,
                "user_id" => parent::is_logged_in()
            );
            $carousel_id = $this->Admin_model->insert_carousel($data);
            if ($carousel_id) {
                if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image, $type)) {
                    $data = substr($carousel_image, strpos($carousel_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                    file_put_contents("assets/images/home_1_" . $carousel_id . "." . $type, $data);
                }

                if ($carousel_image_mobile != "") {
                    if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image_mobile, $type)) {
                        $data = substr($carousel_image_mobile, strpos($carousel_image_mobile, ',') + 1);
                        $type = strtolower($type[1]); // jpg, png, gif
                    
                        $data = base64_decode($data);
                        file_put_contents("assets/images/home_1_" . $carousel_id . "_mobile." . $type, $data);
                    }
                }

                $this->session->set_flashdata("success_message", "Berhasil Add Carousel");
            }
        }

        redirect(base_url("admin/carousel"));
    }

    public function carousel_update_index() {
        $carousel_id = $this->input->post("carousel_id", true);
        $carousel_index = $this->input->post("carousel_index", true);

        if ($carousel_id && $carousel_index) {
            if ($carousel_index == "first") {
                $carousel_index = 1;
            } else if ($carousel_index == "last") {
                $last_index = $this->Admin_model->get_carousel_last_index();
                if (sizeof($last_index) > 0) {
                    $carousel_index = intval($last_index[0]->carousel_index);
                } else {
                    $carousel_index = 1;
                }
            }

            $data = array(
                "carousel_id" => $carousel_id,
                "carousel_index" => intval($carousel_index)
            );
            $this->Admin_model->update_carousel_index_by_id($data);
            $this->session->set_flashdata("success_message", "Perubahan Disimpan");
        }

        redirect(base_url("admin/carousel"));
    }

    public function carousel_detail() {
        $id = $this->uri->segment(3);
        $carousel = $this->Admin_model->get_carousel_by_id($id);
        if (sizeof($id) > 0) {
            $carousel = $carousel[0];
            $data = array(
                "title" => "Edit Carousel",
                "menu_active" => parent::set_admin_menu_active("carousel"),
                "menu_title" => "Edit Carousel",
                "data" => $carousel
            );

            parent::adminview("admin_carousel_detail", $data);
        } else {
            redirect(base_url("admin/carousel"));
        }
    }

    public function carousel_update() {
        $carousel_id = $this->input->post("carousel_id", true);
        $carousel_text_position = $this->input->post("carousel_text_position");
        $carousel_title = trim($this->input->post("carousel_title"));
        $carousel_title_color = $this->input->post("carousel_title_color");
        $carousel_description = trim($this->input->post("carousel_description"));
        $carousel_description_color = $this->input->post("carousel_description_color");
        $carousel_button_color = $this->input->post("carousel_button_color");
        $carousel_button_text = $this->input->post("carousel_button_text");
        $carousel_button_link = $this->input->post("carousel_button_link");
        $carousel_image = $this->input->post("carousel_image");
        $carousel_image_mobile = $this->input->post("carousel_image_mobile");
        $carousel_zoom_out = $this->input->post("carousel_zoom_out");

        $carousel_image_extension = "";
        if ($carousel_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $carousel_image_extension = $type;
            }
        }

        $carousel_image_mobile_extension = "";
        if ($carousel_image_mobile != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image_mobile, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $carousel_image_mobile_extension = $type;
            }
        }

        if ($carousel_id && $carousel_text_position && $carousel_title_color) {
            $data = array(
                "carousel_id" => $carousel_id,
                "carousel_text_position" => $carousel_text_position,
                "carousel_title" => $carousel_title,
                "carousel_title_color" => $carousel_title_color,
                "carousel_description" => $carousel_description,
                "carousel_description_color" => $carousel_description_color,
                "carousel_button_color" => $carousel_button_color,
                "carousel_button_text" => $carousel_button_text,
                "carousel_button_link" => $carousel_button_link,
                "carousel_image_extension" => $carousel_image_extension,
                "carousel_image_mobile_extension" => $carousel_image_mobile_extension,
                "carousel_zoom_out" => $carousel_zoom_out,
                "user_id" => parent::is_logged_in()
            );
            $affected_rows = $this->Admin_model->update_carousel($data);
            if ($affected_rows > 0) {
                if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image, $type)) {
                    $data = substr($carousel_image, strpos($carousel_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                    file_put_contents("assets/images/home_1_" . $carousel_id . "." . $type, $data);
                }

                if ($carousel_image_mobile != "") {
                    if (preg_match('/^data:image\/(\w+);base64,/', $carousel_image_mobile, $type)) {
                        $data = substr($carousel_image_mobile, strpos($carousel_image_mobile, ',') + 1);
                        $type = strtolower($type[1]); // jpg, png, gif
                    
                        $data = base64_decode($data);
                        file_put_contents("assets/images/home_1_" . $carousel_id . "_mobile." . $type, $data);
                    }
                }

                $this->session->set_flashdata("success_message", "Perubahan Disimpan");
            }
        }

        redirect(base_url("admin/carousel_detail/" . $carousel_id));
    }

    public function carousel_delete() {
        $carousel_id = $this->input->post("carousel_id", true);
        if ($carousel_id) {
            $data = array(
                "carousel_id" => $carousel_id,
                "user_id" => parent::is_logged_in()
            );
            $this->Admin_model->delete_carousel($data);
            $this->session->set_flashdata("success_message", "Berhasil Delete Carousel");
        }
        redirect(base_url("admin/carousel"));
    }

    public function tour_highlight()
	{
        $tour_highlight = $this->Admin_model->tour_highlight_get();
		$data = array(
			"title" => "Admin &mdash; Tour Highlight",
			"menu_active" => parent::set_admin_menu_active("tour_highlight"),
            "menu_title" => "Tour Highlight",
            "data" => $tour_highlight
		);
		
		parent::adminview("admin_tour_highlight", $data);
    }

    function tour_highlight_insert() {
        $thi_nama = $this->input->post("thi_nama", true);
        $user_id = parent::is_logged_in();

        if ($thi_nama && $user_id) {
            $data = array(
                "thi_nama" => $thi_nama,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_highlight_insert($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Insert Tour Highlight");
            }
        }
        redirect(base_url("admin/tour_highlight"));
    }

    function tour_highlight_update() {
        $thi_kode = $this->input->post("thi_kode", true);
        $thi_nama = $this->input->post("thi_nama", true);
        $user_id = parent::is_logged_in();

        if ($thi_kode && $thi_nama && $user_id) {
            $data = array(
                "thi_kode" => $thi_kode,
                "thi_nama" => $thi_nama,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_highlight_update($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Edit Tour Highlight");
            }
        }
        redirect(base_url("admin/tour_highlight"));
    }

    function tour_highlight_delete() {
        $thi_kode = $this->input->post("thi_kode", true);
        $user_id = parent::is_logged_in();

        if ($thi_kode && $user_id) {
            $data = array(
                "thi_kode" => $thi_kode,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_highlight_delete($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Tour Highlight");
            }
        }
        redirect(base_url("admin/tour_highlight"));
    }

    public function tour_bonus()
	{
        $tour_bonus = $this->Admin_model->tour_bonus_get();
		$data = array(
			"title" => "Admin &mdash; Tour Bonus",
			"menu_active" => parent::set_admin_menu_active("tour_bonus"),
            "menu_title" => "Tour Bonus",
            "data" => $tour_bonus
		);
		
		parent::adminview("admin_tour_bonus", $data);
    }

    function tour_bonus_insert() {
        $tb_nama = $this->input->post("tb_nama", true);
        $user_id = parent::is_logged_in();

        if ($tb_nama && $user_id) {
            $data = array(
                "tb_nama" => $tb_nama,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_bonus_insert($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Insert Tour Bonus");
            }
        }
        redirect(base_url("admin/tour_bonus"));
    }

    function tour_bonus_update() {
        $tb_kode = $this->input->post("tb_kode", true);
        $tb_nama = $this->input->post("tb_nama", true);
        $user_id = parent::is_logged_in();

        if ($tb_kode && $tb_nama && $user_id) {
            $data = array(
                "tb_kode" => $tb_kode,
                "tb_nama" => $tb_nama,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_bonus_update($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Edit Tour Bonus");
            }
        }
        redirect(base_url("admin/tour_bonus"));
    }

    function tour_bonus_delete() {
        $tb_kode = $this->input->post("tb_kode", true);
        $user_id = parent::is_logged_in();

        if ($tb_kode && $user_id) {
            $data = array(
                "tb_kode" => $tb_kode,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->tour_bonus_delete($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Tour Bonus");
            }
        }
        redirect(base_url("admin/tour_bonus"));
    }

    function add_tour_highlight() {
        parent::show_404_if_not_ajax();
        $thi_nama = $this->input->post("thi_nama", true);
        $user_id = parent::is_logged_in();

        if ($thi_nama && $user_id) {
            $data = array(
                "thi_nama" => $thi_nama,
                "user_id" => $user_id
            );
            $result = $this->Admin_model->add_tour_highlight($data);
            
            echo json_encode(array(
                "status" => "success",
                "thi_kode" => $result["thi_kode"],
                "thi_nama" => $result["thi_nama"]
            ));
        } else {
            echo json_encode(array(
                "status" => "error"
            ));
        }
    }

    function add_tour_bonus() {
        parent::show_404_if_not_ajax();
        $tb_nama = $this->input->post("tb_nama", true);
        $user_id = parent::is_logged_in();

        if ($tb_nama && $user_id) {
            $data = array(
                "tb_nama" => $tb_nama,
                "user_id" => $user_id
            );
            $result = $this->Admin_model->add_tour_bonus($data);
            
            echo json_encode(array(
                "status" => "success",
                "tb_kode" => $result["tb_kode"],
                "tb_nama" => $result["tb_nama"]
            ));
        } else {
            echo json_encode(array(
                "status" => "error"
            ));
        }
    }
    
    public function tour_group()
	{
        parent::load_module("jquery-ui.min");
        $tour_group = $this->Admin_model->tour_group_get();
        $tour_highlight = $this->Admin_model->tour_highlight_get();
        $tour_bonus = $this->Admin_model->tour_bonus_get();
		$data = array(
			"title" => "Admin &mdash; Tour Group",
			"menu_active" => parent::set_admin_menu_active("tour_group"),
            "menu_title" => "Tour Group",
            "tour_group" => $tour_group,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus
		);
		
		parent::adminview("admin_tour_group", $data);
    }

    public function tour_group_insert() {
        $tg_jenis_tour = $this->input->post("tg_jenis_tour", true);
        $tour_group_nama = $this->input->post("tour_group_nama", true);
        $date_start = $this->input->post("date_start", true);
        $date_item = explode("-", $date_start);
        $date_start = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

        $date_end = $this->input->post("date_end", true);
        $date_item = explode("-", $date_end);
        $date_end = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

        $rute = $this->input->post("rute", true);
        $harga_count = intval($this->input->post("harga_count"));
        $harga_arr = array();
        for ($i = 1; $i <= $harga_count; $i++) {
            $harga = intval($this->input->post("harga_" . $i, true));
            if ($harga > 0) {
                $kurs = $this->input->post("kurs_" . $i, true);
                $harga_remarks = $this->input->post("harga_remarks_" . $i, true);
                array_push($harga_arr, array(
                    "harga" => $harga,
                    "kurs" => $kurs,
                    "harga_remarks" => $harga_remarks
                ));
            }
        }
        $cicilan = $this->input->post("tg_cicilan", true);
        $pembimbing = $this->input->post("pembimbing", true);

        $tour_group_image = $this->input->post("tour_group_image");
        $tour_group_image_extension = "";
        if ($tour_group_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $tour_group_image_extension = $type;
            }
        }

        $tour_highlight = $this->input->post("tour_highlight", true);
        $tour_highlight_item = explode(";", $tour_highlight);
        $tour_highlight = array();
        $iLength = sizeof($tour_highlight_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_highlight, $tour_highlight_item[$i]);
        }

        $tour_bonus = $this->input->post("tour_bonus", true);
        $tour_bonus_item = explode(";", $tour_bonus);
        $tour_bonus = array();
        $iLength = sizeof($tour_bonus_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_bonus, $tour_bonus_item[$i]);
        }

        $include_pax = $this->input->post("include_pax", true);
        $exclude_pax = $this->input->post("exclude_pax", true);
        $responsibility = $this->input->post("responsibility", true);
        $tnc = $this->input->post("tnc", true);

        $cp_name_1 = $this->input->post("cp_name_1", true);
        $cp_hp_1 = $this->input->post("cp_hp_1", true);
        $cp_email_1 = $this->input->post("cp_email_1", true);
        $cp_name_2 = $this->input->post("cp_name_2", true);
        $cp_hp_2 = $this->input->post("cp_hp_2", true);
        $cp_email_2 = $this->input->post("cp_email_2", true);
        
        $image_arr = array();
        $itinerary_item_arr = array();
        $itinerary_count = intval($this->input->post("itinerary_count", true));
        for ($i = 1; $i <= $itinerary_count; $i++) {
            $itinerary_image_count = intval($this->input->post("itinerary_image_count_" . $i));
            $itinerary_date = $this->input->post("itinerary_date_" . $i, true);
            $date_item = explode("-", $itinerary_date);
            $itinerary_date = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

            $itinerary_item = array(
                "itinerary_date" => $itinerary_date,
                "itinerary_remarks" => $this->input->post("itinerary_remarks_" . $i, true),
                "itinerary_place" => $this->input->post("itinerary_place_" . $i, true),
                "itinerary_image_position" => $this->input->post("itinerary_image_position_" . $i, true),
                "itinerary_image_count" => $itinerary_image_count
            );

            $itinerary_image_arr = array();
            for ($j = 1; $j <= $itinerary_image_count; $j++) {
                $itinerary_image_item = $this->input->post("itinerary_image_" . $i . "_" . $j);
                array_push($itinerary_image_arr, $itinerary_image_item);

                $image_data = null;
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image_item, $type)) {
                    $type = strtolower($type[1]); // jpg, png, gif

                    $itinerary_item["itinerary_image_" . $j . "_extension"] = $type;
                }
            }
            $itinerary_item["itinerary_image"] = $itinerary_image_arr;
            
            array_push($itinerary_item_arr, $itinerary_item);
        }

        $insert_data = array(
            "user_id" => parent::is_logged_in(),
            "tg_jenis_tour" => $tg_jenis_tour,
            "tour_group_nama" => $tour_group_nama,
            "date_start" => $date_start,
            "date_end" => $date_end,
            "rute" => $rute,
            "harga_arr" => $harga_arr,
            "cicilan" => $cicilan,
            "pembimbing" => $pembimbing,
            "tour_group_image_extension" => $tour_group_image_extension,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus,
            "include_pax" => $include_pax,
            "exclude_pax" => $exclude_pax,
            "responsibility" => $responsibility,
            "tnc" => $tnc,
            "cp_name_1" => $cp_name_1,
            "cp_hp_1" => $cp_hp_1,
            "cp_email_1" => $cp_email_1,
            "cp_name_2" => $cp_name_2,
            "cp_hp_2" => $cp_hp_2,
            "cp_email_2" => $cp_email_2,
            "itinerary_count" => $itinerary_count,
            "itinerary_item_arr" => $itinerary_item_arr
        );
        $result = $this->Admin_model->tour_group_insert($insert_data);

        if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
            $data = substr($tour_group_image, strpos($tour_group_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            $data = base64_decode($data);
            file_put_contents("assets/images/tour_groups/tour_groups_" . $result["tg_kode"] . "." . $type, $data);
        }

        $iLength = sizeof($itinerary_item_arr);
        for ($i = 0; $i < $iLength; $i++) {
            $itinerary_image_arr = $itinerary_item_arr[$i]["itinerary_image"];
            $jLength = sizeof($itinerary_image_arr);
            for ($j = 0; $j < $jLength; $j++) {
                $valid_image = true;
                $itinerary_image = $itinerary_image_arr[$j];
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image, $type)) {
                    $data = substr($itinerary_image, strpos($itinerary_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                
                    if ($data === false) {
                        $valid_image = false;
                    }
                } else {
                    $valid_image = false;
                }

                if ($valid_image) {
                    file_put_contents("assets/images/tour_groups/itinerary_image_" . $result["tgi_kode_arr"][$i] . "_" . ($j + 1) . "." . $type, $data);
                }
            }
        }

        $this->session->set_flashdata("success_message", "Berhasil Insert Tour Group");

        redirect(base_url("admin/tour_group"));
    }

    public function tour_group_detail() {
        $id = $this->uri->segment(3);
        $detail = $this->Admin_model->get_tour_group_by_id($id);
        if (sizeof($detail) > 0) {
            $dayofweek = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            $tour_group_harga = $this->Admin_model->get_tour_group_harga_by_id($id);
            $itinerary = $this->Admin_model->get_itinerary_by_group_id($id);
            $iLength = sizeof($itinerary);
            for ($i = 0; $i < $iLength; $i++) {
                $timestamp = strtotime($itinerary[$i]->tgi_tanggal);
                $day = date('w', $timestamp);
                $date = explode("-", $itinerary[$i]->tgi_tanggal);
                $itinerary[$i]->tgi_tanggal = $date[2] . "-" . $date[1] . "-" . $date[0];
                $itinerary[$i]->day = $dayofweek[$day];
            }

            $detail = $detail[0];
            $date = explode("-", $detail->tg_tglStart);
            $detail->tg_tglStart = $date[2] . "-" . $date[1] . "-" . $date[0];

            $date = explode("-", $detail->tg_tglEnd);
            $detail->tg_tglEnd = $date[2] . "-" . $date[1] . "-" . $date[0];

            parent::load_module("jquery-ui.min");
            $tour_highlight = $this->Admin_model->tour_highlight_get();
            $tour_bonus = $this->Admin_model->tour_bonus_get();
            $data = array(
                "title" => $detail->tg_nama,
                "menu_active" => parent::set_admin_menu_active("tour_group"),
                "menu_title" => "Edit Tour Group : " . $detail->tg_nama,
                "data" => $detail,
                "harga" => $tour_group_harga,
                "tour_highlight" => $tour_highlight,
                "tour_bonus" => $tour_bonus,
                "itinerary" => $itinerary
            );
        
            parent::adminview("admin_tour_group_detail", $data);
        } else {
            redirect(base_url("admin/tour_group"));
        }
    }

    public function tour_group_update() {
        $tg_kode = $this->input->post("tg_kode", true);
        $tg_jenis_tour = $this->input->post("tg_jenis_tour", true);
        $tour_group_nama = $this->input->post("tour_group_nama", true);
        $date_start = $this->input->post("date_start", true);
        $date_item = explode("-", $date_start);
        $date_start = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

        $date_end = $this->input->post("date_end", true);
        $date_item = explode("-", $date_end);
        $date_end = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

        $rute = $this->input->post("rute", true);
        $harga_count = intval($this->input->post("harga_count"));
        $harga_arr = array();
        for ($i = 1; $i <= $harga_count; $i++) {
            $harga = intval($this->input->post("harga_" . $i, true));
            if ($harga > 0) {
                $kurs = $this->input->post("kurs_" . $i, true);
                $harga_remarks = $this->input->post("harga_remarks_" . $i, true);
                array_push($harga_arr, array(
                    "harga" => $harga,
                    "kurs" => $kurs,
                    "harga_remarks" => $harga_remarks
                ));
            }
        }

        $cicilan = $this->input->post("tg_cicilan", true);
        $pembimbing = $this->input->post("pembimbing", true);

        $tour_group_image = $this->input->post("tour_group_image");
        $tour_group_image_extension = "";
        if ($tour_group_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $tour_group_image_extension = $type;
            }
        }

        $tour_highlight = $this->input->post("tour_highlight", true);
        $tour_highlight_item = explode(";", $tour_highlight);
        $tour_highlight = array();
        $iLength = sizeof($tour_highlight_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_highlight, $tour_highlight_item[$i]);
        }

        $tour_bonus = $this->input->post("tour_bonus", true);
        $tour_bonus_item = explode(";", $tour_bonus);
        $tour_bonus = array();
        $iLength = sizeof($tour_bonus_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_bonus, $tour_bonus_item[$i]);
        }

        $include_pax = $this->input->post("include_pax", true);
        $exclude_pax = $this->input->post("exclude_pax", true);
        $responsibility = $this->input->post("responsibility", true);
        $tnc = $this->input->post("tnc", true);

        $cp_name_1 = $this->input->post("cp_name_1", true);
        $cp_hp_1 = $this->input->post("cp_hp_1", true);
        $cp_email_1 = $this->input->post("cp_email_1", true);
        $cp_name_2 = $this->input->post("cp_name_2", true);
        $cp_hp_2 = $this->input->post("cp_hp_2", true);
        $cp_email_2 = $this->input->post("cp_email_2", true);
        
        $update_data = array(
            "user_id" => parent::is_logged_in(),
            "tg_kode" => $tg_kode,
            "tg_jenis_tour" => $tg_jenis_tour,
            "tour_group_nama" => $tour_group_nama,
            "date_start" => $date_start,
            "date_end" => $date_end,
            "rute" => $rute,
            "harga_arr" => $harga_arr,
            "cicilan" => $cicilan,
            "pembimbing" => $pembimbing,
            "tour_group_image_extension" => $tour_group_image_extension,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus,
            "include_pax" => $include_pax,
            "exclude_pax" => $exclude_pax,
            "responsibility" => $responsibility,
            "tnc" => $tnc,
            "cp_name_1" => $cp_name_1,
            "cp_hp_1" => $cp_hp_1,
            "cp_email_1" => $cp_email_1,
            "cp_name_2" => $cp_name_2,
            "cp_hp_2" => $cp_hp_2,
            "cp_email_2" => $cp_email_2
        );
        $this->Admin_model->tour_group_update($update_data);

        if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
            $data = substr($tour_group_image, strpos($tour_group_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            $data = base64_decode($data);
            file_put_contents("assets/images/tour_groups/tour_groups_" . $tg_kode . "." . $type, $data);
        }

        $this->session->set_flashdata("success_message", "Perubahan Disimpan");

        redirect(base_url("admin/tour_group_detail/" . $tg_kode));
    }

    public function tour_group_delete() {
        $tg_kode = $this->input->post("tg_kode", true);
        $user_id = parent::is_logged_in();
        if ($tg_kode) {
            $data = array(
                "tg_kode" => $tg_kode,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->delete_tour_group($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Tour Group");
            }
        }

        redirect(base_url("admin/tour_group"));
    }

    public function itinerary_insert() {
        $source = $this->input->post("source");
        $tg_kode = $this->input->post("tg_kode", true);
        $itinerary_day = $this->input->post("itinerary_day", true);
        $itinerary_date = $this->input->post("itinerary_date", true);
        $date_item = explode("-", $itinerary_date);
        if (sizeof($date_item > 0)) {
            $itinerary_date = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];
        }

        $itinerary_remarks = $this->input->post("itinerary_remarks", true);
        $itinerary_place = $this->input->post("itinerary_place", true);
        $itinerary_image_position = $this->input->post("itinerary_image_position", true);
        $itinerary_image_count = intval($this->input->post("itinerary_image_count"));

        $image_arr = array();
        
        $itinerary_item = array(
            "tg_kode" => $tg_kode,
            "itinerary_day" => $itinerary_day,
            "itinerary_date" => $itinerary_date,
            "itinerary_remarks" => $itinerary_remarks,
            "itinerary_place" => $itinerary_place,
            "itinerary_image_position" => $itinerary_image_position,
            "itinerary_image_count" => $itinerary_image_count,
            "user_id" => parent::is_logged_in()
        );

        $itinerary_image_arr = array();
        for ($j = 1; $j <= $itinerary_image_count; $j++) {
            $itinerary_image_item = $this->input->post("itinerary_image_" . $j);
            array_push($itinerary_image_arr, $itinerary_image_item);

            $image_data = null;
            if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image_item, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif

                $itinerary_item["itinerary_image_" . $j . "_extension"] = $type;
            }
        }

        $tgi_kode = $this->Admin_model->insert_itinerary($itinerary_item);

        if ($tgi_kode > 0) {
            $jLength = sizeof($itinerary_image_arr);
            for ($j = 0; $j < $jLength; $j++) {
                $itinerary_image = $itinerary_image_arr[$j];
                $data = null;
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image, $type)) {
                    $data = substr($itinerary_image, strpos($itinerary_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                }

                file_put_contents("assets/images/tour_groups/itinerary_image_" . $tgi_kode . "_" . ($j + 1) . "." . $type, $data);
            }

            $this->session->set_flashdata("success_message", "Berhasil Add Itinerary");
        }

        if ($source == "tour_group") {
            redirect(base_url("admin/tour_group_detail/" . $tg_kode));
        } else {
            redirect(base_url("admin/tour_package_detail/" . $tg_kode));
        }
    }

    public function itinerary_update() {
        $source = $this->input->post("source");
        $tg_kode = $this->input->post("tg_kode", true);
        $tgi_kode = $this->input->post("tgi_kode", true);
        $itinerary_day = $this->input->post("itinerary_day", true);
        $itinerary_date = $this->input->post("itinerary_date", true);
        $date_item = explode("-", $itinerary_date);
        if (sizeof($date_item) > 0) {
            $itinerary_date = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];
        }

        $itinerary_remarks = $this->input->post("itinerary_remarks", true);
        $itinerary_place = $this->input->post("itinerary_place", true);
        $itinerary_image_position = $this->input->post("itinerary_image_position", true);
        $itinerary_image_count = intval($this->input->post("itinerary_image_count"));

        $image_arr = array();
        
        $itinerary_item = array(
            "tg_kode" => $tg_kode,
            "tgi_kode" => $tgi_kode,
            "itinerary_day" => $itinerary_day,
            "itinerary_date" => $itinerary_date,
            "itinerary_remarks" => $itinerary_remarks,
            "itinerary_place" => $itinerary_place,
            "itinerary_image_position" => $itinerary_image_position,
            "itinerary_image_count" => $itinerary_image_count,
            "user_id" => parent::is_logged_in()
        );

        $itinerary_image_arr = array();
        for ($j = 1; $j <= $itinerary_image_count; $j++) {
            $itinerary_image_item = $this->input->post("itinerary_image_" . $j);
            array_push($itinerary_image_arr, $itinerary_image_item);

            $image_data = null;
            if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image_item, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif

                $itinerary_item["itinerary_image_" . $j . "_extension"] = $type;
            }
        }

        $affected_rows = $this->Admin_model->update_itinerary($itinerary_item);

        if ($affected_rows > 0) {
            $jLength = sizeof($itinerary_image_arr);
            for ($j = 0; $j < $jLength; $j++) {
                $itinerary_image = $itinerary_image_arr[$j];
                $data = null;
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image, $type)) {
                    $data = substr($itinerary_image, strpos($itinerary_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                }

                file_put_contents("assets/images/tour_groups/itinerary_image_" . $tgi_kode . "_" . ($j + 1) . "." . $type, $data);
            }

            $this->session->set_flashdata("success_message", "Berhasil Edit Itinerary");
        }

        if ($source == "tour_group") {
            redirect(base_url("admin/tour_group_detail/" . $tg_kode));
        } else {
            redirect(base_url("admin/tour_package_detail/" . $tg_kode));
        }
    }

    public function itinerary_delete() {
        $source = $this->input->post("source");
        $tg_kode = $this->input->post("tg_kode", true);
        $tgi_kode = $this->input->post("tgi_kode", true);
        $user_id = parent::is_logged_in();

        if ($tgi_kode) {
            $data = array(
                "tg_kode" => $tg_kode,
                "tgi_kode" => $tgi_kode,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->delete_itinerary($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Itinerary");
            }
        }

        if ($source == "tour_group") {
            redirect(base_url("admin/tour_group_detail/" . $tg_kode));
        } else {
            redirect(base_url("admin/tour_package_detail/" . $tg_kode));
        }
    }
    
    public function tour_package()
	{
        $tour_package = $this->Admin_model->tour_package_get();
        $tour_highlight = $this->Admin_model->tour_highlight_get();
        $tour_bonus = $this->Admin_model->tour_bonus_get();
        parent::load_module("jquery-ui.min");
		$data = array(
			"title" => "Admin &mdash; Tour Package",
			"menu_active" => parent::set_admin_menu_active("tour_package"),
            "menu_title" => "Tour Package",
            "tour_package" => $tour_package,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus
		);
		
		parent::adminview("admin_tour_package", $data);
    }

    public function tour_package_insert() {
        $tg_jenis_tour = $this->input->post("tg_jenis_tour", true);
        $tour_group_nama = $this->input->post("tour_group_nama", true);
        $tour_group_description = $this->input->post("tour_group_description", true);

        $tanggal_count = intval($this->input->post("tanggal_count"));
        $tanggal_arr = array();
        for ($i = 1; $i <= $tanggal_count; $i++) {
            $date_start = $this->input->post("date_start_" . $i, true);
            $date_end = $this->input->post("date_end_" . $i, true);
            if ($date_start != "" && $date_end != "") {
                $date_item = explode("-", $date_start);
                $date_start = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

                $date_item = explode("-", $date_end);
                $date_end = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];
                array_push($tanggal_arr, array(
                    "tg_tglStart" => $date_start,
                    "tg_tglEnd" => $date_end
                ));
            }
        }

        $durasi = $this->input->post("durasi", true);

        $rute = $this->input->post("rute", true);
        $harga_count = intval($this->input->post("harga_count"));
        $harga_arr = array();
        for ($i = 1; $i <= $harga_count; $i++) {
            $harga = intval($this->input->post("harga_" . $i, true));
            if ($harga > 0) {
                $kurs = $this->input->post("kurs_" . $i, true);
                $harga_remarks = $this->input->post("harga_remarks_" . $i, true);
                array_push($harga_arr, array(
                    "harga" => $harga,
                    "kurs" => $kurs,
                    "harga_remarks" => $harga_remarks
                ));
            }
        }
        $cicilan = $this->input->post("tg_cicilan", true);
        $pembimbing = $this->input->post("pembimbing", true);

        $tour_group_image = $this->input->post("tour_group_image");
        $tour_group_image_extension = "";
        if ($tour_group_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $tour_group_image_extension = $type;
            }
        }

        $tour_highlight = $this->input->post("tour_highlight", true);
        $tour_highlight_item = explode(";", $tour_highlight);
        $tour_highlight = array();
        $iLength = sizeof($tour_highlight_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_highlight, $tour_highlight_item[$i]);
        }

        $tour_bonus = $this->input->post("tour_bonus", true);
        $tour_bonus_item = explode(";", $tour_bonus);
        $tour_bonus = array();
        $iLength = sizeof($tour_bonus_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_bonus, $tour_bonus_item[$i]);
        }

        $include_pax = $this->input->post("include_pax", true);
        $exclude_pax = $this->input->post("exclude_pax", true);
        $responsibility = $this->input->post("responsibility", true);
        $tnc = $this->input->post("tnc", true);

        $cp_name_1 = $this->input->post("cp_name_1", true);
        $cp_hp_1 = $this->input->post("cp_hp_1", true);
        $cp_email_1 = $this->input->post("cp_email_1", true);
        $cp_name_2 = $this->input->post("cp_name_2", true);
        $cp_hp_2 = $this->input->post("cp_hp_2", true);
        $cp_email_2 = $this->input->post("cp_email_2", true);
        
        $image_arr = array();
        $itinerary_item_arr = array();
        $itinerary_count = intval($this->input->post("itinerary_count", true));
        for ($i = 1; $i <= $itinerary_count; $i++) {
            $itinerary_image_count = intval($this->input->post("itinerary_image_count_" . $i));
            $itinerary_date = $this->input->post("itinerary_date_" . $i, true);

            $itinerary_item = array(
                "itinerary_day" => $itinerary_date,
                "itinerary_remarks" => $this->input->post("itinerary_remarks_" . $i, true),
                "itinerary_place" => $this->input->post("itinerary_place_" . $i, true),
                "itinerary_image_position" => $this->input->post("itinerary_image_position_" . $i, true),
                "itinerary_image_count" => $itinerary_image_count
            );

            $itinerary_image_arr = array();
            for ($j = 1; $j <= $itinerary_image_count; $j++) {
                $itinerary_image_item = $this->input->post("itinerary_image_" . $i . "_" . $j);
                array_push($itinerary_image_arr, $itinerary_image_item);

                $image_data = null;
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image_item, $type)) {
                    $type = strtolower($type[1]); // jpg, png, gif

                    $itinerary_item["itinerary_image_" . $j . "_extension"] = $type;
                }
            }
            $itinerary_item["itinerary_image"] = $itinerary_image_arr;
            
            array_push($itinerary_item_arr, $itinerary_item);
        }

        $insert_data = array(
            "user_id" => parent::is_logged_in(),
            "tg_jenis_tour" => $tg_jenis_tour,
            "tour_group_nama" => $tour_group_nama,
            "tour_group_description" => $tour_group_description,
            "tanggal_arr" => $tanggal_arr,
            "durasi" => $durasi,
            "rute" => $rute,
            "harga_arr" => $harga_arr,
            "pembimbing" => $pembimbing,
            "cicilan" => $cicilan,
            "tour_group_image_extension" => $tour_group_image_extension,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus,
            "include_pax" => $include_pax,
            "exclude_pax" => $exclude_pax,
            "responsibility" => $responsibility,
            "tnc" => $tnc,
            "cp_name_1" => $cp_name_1,
            "cp_hp_1" => $cp_hp_1,
            "cp_email_1" => $cp_email_1,
            "cp_name_2" => $cp_name_2,
            "cp_hp_2" => $cp_hp_2,
            "cp_email_2" => $cp_email_2,
            "itinerary_count" => $itinerary_count,
            "itinerary_item_arr" => $itinerary_item_arr
        );
        $result = $this->Admin_model->tour_package_insert($insert_data);

        if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
            $data = substr($tour_group_image, strpos($tour_group_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            $data = base64_decode($data);
            file_put_contents("assets/images/tour_groups/tour_groups_" . $result["tg_kode"] . "." . $type, $data);
        }

        $iLength = sizeof($itinerary_item_arr);
        for ($i = 0; $i < $iLength; $i++) {
            $itinerary_image_arr = $itinerary_item_arr[$i]["itinerary_image"];
            $jLength = sizeof($itinerary_image_arr);
            for ($j = 0; $j < $jLength; $j++) {
                $valid_image = true;
                $itinerary_image = $itinerary_image_arr[$j];
                if (preg_match('/^data:image\/(\w+);base64,/', $itinerary_image, $type)) {
                    $data = substr($itinerary_image, strpos($itinerary_image, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                
                    if ($data === false) {
                        $valid_image = false;
                    }
                } else {
                    $valid_image = false;
                }

                if ($valid_image) {
                    file_put_contents("assets/images/tour_groups/itinerary_image_" . $result["tgi_kode_arr"][$i] . "_" . ($j + 1) . "." . $type, $data);
                }
            }
        }

        $this->session->set_flashdata("success_message", "Berhasil Insert Tour Package");

        redirect(base_url("admin/tour_package"));
    }

    public function tour_package_detail() {
        $id = $this->uri->segment(3);
        $detail = $this->Admin_model->get_tour_group_by_id($id);
        if (sizeof($detail) > 0) {
            $dayofweek = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            $tour_package_date = $this->Admin_model->get_tour_package_date_by_id($id);
            $iLength = sizeof($tour_package_date);
            for ($i = 0; $i < $iLength; $i++) {
                $date_item = explode("-", $tour_package_date[$i]->tg_tglStart);
                $tour_package_date[$i]->tg_tglStart = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

                $date_item = explode("-", $tour_package_date[$i]->tg_tglEnd);
                $tour_package_date[$i]->tg_tglEnd = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];
            }

            $tour_group_harga = $this->Admin_model->get_tour_group_harga_by_id($id);
            $itinerary = $this->Admin_model->get_itinerary_by_group_id($id);

            $detail = $detail[0];
            $tour_highlight = $this->Admin_model->tour_highlight_get();
            $tour_bonus = $this->Admin_model->tour_bonus_get();
            parent::load_module("jquery-ui.min");
            $data = array(
                "title" => $detail->tg_nama,
                "menu_active" => parent::set_admin_menu_active("tour_package"),
                "menu_title" => "Edit Tour Package : " . $detail->tg_nama,
                "data" => $detail,
                "date" => $tour_package_date,
                "harga" => $tour_group_harga,
                "tour_highlight" => $tour_highlight,
                "tour_bonus" => $tour_bonus,
                "itinerary" => $itinerary
            );
        
            parent::adminview("admin_tour_package_detail", $data);
        } else {
            redirect(base_url("admin/tour_package"));
        }
    }

    public function tour_package_update() {
        $tg_kode = $this->input->post("tg_kode", true);
        $tg_jenis_tour = $this->input->post("tg_jenis_tour", true);
        $tour_group_nama = $this->input->post("tour_group_nama", true);
        $tour_group_description = $this->input->post("tour_group_description", true);

        $tanggal_count = intval($this->input->post("tanggal_count"));
        $tanggal_arr = array();
        for ($i = 1; $i <= $tanggal_count; $i++) {
            $date_start = $this->input->post("date_start_" . $i, true);
            $date_end = $this->input->post("date_end_" . $i, true);
            if ($date_start != "" && $date_end != "") {
                $date_item = explode("-", $date_start);
                $date_start = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];

                $date_item = explode("-", $date_end);
                $date_end = $date_item[2] . "-" . $date_item[1] . "-" . $date_item[0];
                array_push($tanggal_arr, array(
                    "tg_tglStart" => $date_start,
                    "tg_tglEnd" => $date_end
                ));
            }
        }

        $durasi = $this->input->post("durasi", true);

        $rute = $this->input->post("rute", true);
        $harga_count = intval($this->input->post("harga_count"));
        $harga_arr = array();
        for ($i = 1; $i <= $harga_count; $i++) {
            $harga = intval($this->input->post("harga_" . $i, true));
            if ($harga > 0) {
                echo $harga . "<br />";
                $kurs = $this->input->post("kurs_" . $i, true);
                $harga_remarks = $this->input->post("harga_remarks_" . $i, true);
                array_push($harga_arr, array(
                    "harga" => $harga,
                    "kurs" => $kurs,
                    "harga_remarks" => $harga_remarks
                ));
            }
        }

        $cicilan = $this->input->post("tg_cicilan", true);
        $pembimbing = $this->input->post("pembimbing", true);

        $tour_group_image = $this->input->post("tour_group_image");
        $tour_group_image_extension = "";
        if ($tour_group_image != "") {
            if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
                $type = strtolower($type[1]); // jpg, png, gif
                $tour_group_image_extension = $type;
            }
        }

        $tour_highlight = $this->input->post("tour_highlight", true);
        $tour_highlight_item = explode(";", $tour_highlight);
        $tour_highlight = array();
        $iLength = sizeof($tour_highlight_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_highlight, $tour_highlight_item[$i]);
        }

        $tour_bonus = $this->input->post("tour_bonus", true);
        $tour_bonus_item = explode(";", $tour_bonus);
        $tour_bonus = array();
        $iLength = sizeof($tour_bonus_item);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($tour_bonus, $tour_bonus_item[$i]);
        }

        $include_pax = $this->input->post("include_pax", true);
        $exclude_pax = $this->input->post("exclude_pax", true);
        $responsibility = $this->input->post("responsibility", true);
        $tnc = $this->input->post("tnc", true);

        $cp_name_1 = $this->input->post("cp_name_1", true);
        $cp_hp_1 = $this->input->post("cp_hp_1", true);
        $cp_email_1 = $this->input->post("cp_email_1", true);
        $cp_name_2 = $this->input->post("cp_name_2", true);
        $cp_hp_2 = $this->input->post("cp_hp_2", true);
        $cp_email_2 = $this->input->post("cp_email_2", true);
        
        $update_data = array(
            "user_id" => parent::is_logged_in(),
            "tg_kode" => $tg_kode,
            "tg_jenis_tour" => $tg_jenis_tour,
            "tour_group_nama" => $tour_group_nama,
            "tour_group_description" => $tour_group_description,
            "tanggal_arr" => $tanggal_arr,
            "durasi" => $durasi,
            "rute" => $rute,
            "harga_arr" => $harga_arr,
            "cicilan" => $cicilan,
            "pembimbing" => $pembimbing,
            "tour_group_image_extension" => $tour_group_image_extension,
            "tour_highlight" => $tour_highlight,
            "tour_bonus" => $tour_bonus,
            "include_pax" => $include_pax,
            "exclude_pax" => $exclude_pax,
            "responsibility" => $responsibility,
            "tnc" => $tnc,
            "cp_name_1" => $cp_name_1,
            "cp_hp_1" => $cp_hp_1,
            "cp_email_1" => $cp_email_1,
            "cp_name_2" => $cp_name_2,
            "cp_hp_2" => $cp_hp_2,
            "cp_email_2" => $cp_email_2
        );
        $this->Admin_model->tour_package_update($update_data);

        if (preg_match('/^data:image\/(\w+);base64,/', $tour_group_image, $type)) {
            $data = substr($tour_group_image, strpos($tour_group_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            $data = base64_decode($data);
            file_put_contents("assets/images/tour_groups/tour_groups_" . $tg_kode . "." . $type, $data);
        }

        $this->session->set_flashdata("success_message", "Perubahan Disimpan");

        redirect(base_url("admin/tour_package_detail/" . $tg_kode));
    }

    public function tour_package_delete() {
        $tg_kode = $this->input->post("tg_kode", true);
        $user_id = parent::is_logged_in();
        if ($tg_kode) {
            $data = array(
                "tg_kode" => $tg_kode,
                "user_id" => $user_id
            );
            $affected_rows = $this->Admin_model->delete_tour_group($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Tour Package");
            }
        }

        redirect(base_url("admin/tour_package"));
    }
    
    public function article()
	{
        $article = $this->Admin_model->get_article();
		$data = array(
			"title" => "Admin &mdash; Article",
			"menu_active" => parent::set_admin_menu_active("article"),
            "menu_title" => "Article",
            "data" => $article
		);
		
		parent::adminview("admin_article", $data);
    }

    public function article_insert() {
        $title = $this->input->post("title");
        $title_image = $this->input->post("title_image");
        $image_type = "";
        if (preg_match('/^data:image\/(\w+);base64,/', $title_image, $image_type)) {
            $image_type = strtolower($image_type[1]); // jpg, png, gif
        }
        $title_image_extension = $image_type;

        $content_type = $this->input->post("content_type");
        $content_arr = array();
        $image_arr = array();
        $type = explode(";", $content_type);
        $iLength = sizeof($type);
        for ($i = 0; $i < $iLength; $i++) {
            $content = $this->input->post("content_" . $i);
            if ($type[$i] == "text") {
                array_push($content_arr, array(
                    "type" => $type[$i],
                    "content" => $content
                ));
            } else {
                $image_type = "";
                if (preg_match('/^data:image\/(\w+);base64,/', $content, $image_type)) {
                    $image_type = strtolower($image_type[1]); // jpg, png, gif
                }
                array_push($content_arr, array(
                    "type" => $type[$i],
                    "content" => $image_type
                ));

                array_push($image_arr, $content);
            }
        }

        $data = array(
            "ta_title" => $title,
            "ta_image_extension" => $title_image_extension,
            "content_arr" => $content_arr,
            "user_id" => parent::is_logged_in()
        );
        $result = $this->Admin_model->insert_article($data);

        if (preg_match('/^data:image\/(\w+);base64,/', $title_image, $type)) {
            $data = substr($title_image, strpos($title_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            $data = base64_decode($data);
            file_put_contents("assets/images/article/article_" . $result["ta_kode"] . "." . $type, $data);
        }

        $tac_image_arr = $result["tac_image_arr"];
        $iLength = sizeof($tac_image_arr);
        for ($i = 0; $i < $iLength; $i++) {
            if (preg_match('/^data:image\/(\w+);base64,/', $image_arr[$i], $type)) {
                $data = substr($image_arr[$i], strpos($image_arr[$i], ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
            
                $data = base64_decode($data);
                file_put_contents("assets/images/article/article_content_" . $tac_image_arr[$i] . "." . $type, $data);
            }
        }

        $this->session->set_flashdata("success_message", "Berhasil Insert Article");

        redirect(base_url("admin/article"));
    }

    public function article_detail() {
        $id = $this->uri->segment(3);
        $article = $this->Admin_model->get_article_by_id($id);
        if (sizeof($article) > 0) {
            $detail = $this->Admin_model->get_article_detail_by_id($id);
            $data = array(
                "title" => "Admin &mdash; Edit Article",
                "menu_active" => parent::set_admin_menu_active("article"),
                "menu_title" => "Edit Article : " . $article[0]->ta_title,
                "data" => $article[0],
                "detail" => $detail
            );
            
            parent::adminview("admin_article_detail", $data);
        } else {
            redirect(base_url("admin/article"));
        }
    }

    public function article_update() {
        $ta_kode = $this->input->post("ta_kode", true);
        if ($ta_kode) {
            $title = $this->input->post("title");
            $title_image = $this->input->post("title_image");
            $image_type = "";
            if (preg_match('/^data:image\/(\w+);base64,/', $title_image, $image_type)) {
                $image_type = strtolower($image_type[1]); // jpg, png, gif
            }
            $title_image_extension = $image_type;

            $content_type = $this->input->post("content_type");
            $content_arr = array();
            $image_arr = array();
            $type = explode(";", $content_type);
            $iLength = sizeof($type);
            for ($i = 0; $i < $iLength; $i++) {
                $content = $this->input->post("content_" . $i);
                if ($type[$i] == "text") {
                    array_push($content_arr, array(
                        "type" => $type[$i],
                        "content" => $content
                    ));
                } else {
                    $image_type = "";
                    if (preg_match('/^data:image\/(\w+);base64,/', $content, $image_type)) {
                        $image_type = strtolower($image_type[1]); // jpg, png, gif
                    }
                    array_push($content_arr, array(
                        "type" => $type[$i],
                        "content" => $image_type
                    ));

                    array_push($image_arr, $content);
                }
            }

            $data = array(
                "ta_kode" => $ta_kode,
                "ta_title" => $title,
                "ta_image_extension" => $title_image_extension,
                "content_arr" => $content_arr,
                "user_id" => parent::is_logged_in()
            );
            $result = $this->Admin_model->update_article($data);

            if (preg_match('/^data:image\/(\w+);base64,/', $title_image, $type)) {
                $data = substr($title_image, strpos($title_image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
            
                $data = base64_decode($data);
                file_put_contents("assets/images/article/article_" . $ta_kode . "." . $type, $data);
            }

            $tac_image_arr = $result["tac_image_arr"];
            $iLength = sizeof($tac_image_arr);
            for ($i = 0; $i < $iLength; $i++) {
                if (preg_match('/^data:image\/(\w+);base64,/', $image_arr[$i], $type)) {
                    $data = substr($image_arr[$i], strpos($image_arr[$i], ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                
                    $data = base64_decode($data);
                    file_put_contents("assets/images/article/article_content_" . $tac_image_arr[$i] . "." . $type, $data);
                }
            }

            $this->session->set_flashdata("success_message", "Berhasil Edit Article");
        }
        redirect(base_url("admin/article_detail/" . $ta_kode));
    }

    public function article_delete() {
        $ta_kode = $this->input->post("ta_kode", true);
        $user_id = parent::is_logged_in();
        $data = array(
            "ta_kode" => $ta_kode,
            "user_id" => $user_id
        );
        $affected_rows = $this->Admin_model->delete_article($data);
        if ($affected_rows > 0) {
            $this->session->set_flashdata("success_message", "Berhasil Delete Article");
        }
        redirect(base_url("admin/article"));
    }

    public function services() {
        $services = $this->Admin_model->get_services();
        $data = array(
			"title" => "Admin &mdash; Services",
			"menu_active" => parent::set_admin_menu_active("services"),
            "menu_title" => "Services",
            "data" => $services
		);
		
		parent::adminview("admin_services", $data);
    }

    public function service_insert() {
        $ts_nama = $this->input->post("ts_nama");
        $ts_image = $this->input->post("ts_image");
        $ts_keterangan = $this->input->post("ts_keterangan");

        if ($ts_nama && $ts_keterangan) {
            $image_type = "";
            if (preg_match('/^data:image\/(\w+);base64,/', $ts_image, $image_type)) {
                $image_type = strtolower($image_type[1]); // jpg, png, gif
            }
            $ts_image_extension = $image_type;

            $data = array(
                "ts_nama" => $ts_nama,
                "ts_image_extension" => $ts_image_extension,
                "ts_keterangan" => $ts_keterangan,
                "user_id" => parent::is_logged_in()
            );
            $insert_id = $this->Admin_model->insert_service($data);
            if ($insert_id) {
                if (preg_match('/^data:image\/(\w+);base64,/', $ts_image, $type)) {
                    $data = substr($ts_image, strpos($ts_image, ',') + 1);
                
                    $data = base64_decode($data);
                    file_put_contents("assets/images/services/service_" . $insert_id . "." . $image_type, $data);
                }

                $this->session->set_flashdata("success_message", "Berhasil Insert Service");
            }
        }

        redirect(base_url("admin/services"));
    }

    public function service_detail() {
        $id = $this->uri->segment(3);
        $detail = $this->Admin_model->get_service_by_id($id);
        if (sizeof($detail) > 0) {
            $detail = $detail[0];
            $data = array(
                "title" => $detail->ts_nama,
                "menu_active" => parent::set_admin_menu_active("services"),
                "menu_title" => "Edit Service : " . $detail->ts_nama,
                "data" => $detail
            );
        
            parent::adminview("admin_services_detail", $data);
        } else {
            redirect(base_url("admin/service"));
        }
    }

    public function service_update() {
        $ts_kode = $this->input->post("ts_kode", true);
        $ts_nama = $this->input->post("ts_nama");
        $ts_image = $this->input->post("ts_image");
        $ts_keterangan = $this->input->post("ts_keterangan");

        if ($ts_kode && $ts_nama && $ts_keterangan) {
            $image_type = "";
            if (preg_match('/^data:image\/(\w+);base64,/', $ts_image, $image_type)) {
                $image_type = strtolower($image_type[1]); // jpg, png, gif
            }
            $ts_image_extension = $image_type;

            $data = array(
                "ts_kode" => $ts_kode,
                "ts_nama" => $ts_nama,
                "ts_image_extension" => $ts_image_extension,
                "ts_keterangan" => $ts_keterangan,
                "user_id" => parent::is_logged_in()
            );
            $affected_rows = $this->Admin_model->update_service($data);
            if ($affected_rows > 0) {
                if (preg_match('/^data:image\/(\w+);base64,/', $ts_image, $type)) {
                    $data = substr($ts_image, strpos($ts_image, ',') + 1);
                
                    $data = base64_decode($data);
                    file_put_contents("assets/images/services/service_" . $ts_kode . "." . $image_type, $data);
                }

                $this->session->set_flashdata("success_message", "Perubahan Disimpan");
            }
        }

        redirect(base_url("admin/service_detail/" . $ts_kode));
    }

    public function service_delete() {
        $ts_kode = $this->input->post("ts_kode", true);
        if ($ts_kode) {
            $data = array(
                "ts_kode" => $ts_kode,
                "user_id" => parent::is_logged_in()
            );
            $affected_rows = $this->Admin_model->delete_service($data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata("success_message", "Berhasil Delete Service");
            }
        }

        redirect(base_url("admin/services"));
    }
    
    public function contact()
	{
		$data = array(
			"title" => "Admin &mdash; Contact",
			"menu_active" => parent::set_admin_menu_active("contact"),
			"menu_title" => "Contact"
		);
		
		parent::adminview("admin_contact", $data);
    }
    
    public function about()
	{
		$data = array(
			"title" => "Admin &mdash; About Us",
			"menu_active" => parent::set_admin_menu_active("about_us"),
			"menu_title" => "About Us"
		);
		
		parent::adminview("admin_about", $data);
    }
    
    public function settings()
	{
		$data = array(
            "title" => "Admin &mdash; Settings",
            "menu_active" => parent::set_admin_menu_active("about_us"),
			"menu_title" => "Settings"
		);
		
		parent::adminview("admin_settings", $data);
    }
    
    public function do_change_password() {
        $oldPassword = $this->input->post("old-password", true);
		$newPassword = $this->input->post("new-password", true);

		$stored_password = $this->Admin_model->get_password()->admin_password;
		if (password_verify($oldPassword, $stored_password)) {
			$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$this->Admin_model->update_password($newPassword);
			$this->session->set_flashdata("success_message", "Sukses ganti password");
			redirect(base_url("admin/settings"));
		} else {
			$this->session->set_flashdata("error_message", "Password lama salah");
			redirect(base_url("admin/settings"));
		}
    }
}
