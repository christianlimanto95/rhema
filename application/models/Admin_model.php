<?php

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_tour_peserta($offset, $view_per_page) {
        $query = $this->db->query("
            SELECT tp.tp_kodePeserta, tp.tg_kode, tg.tg_nama, CASE WHEN tg.tg_jenis = 1 THEN tg.tg_tglStart ELSE tpd.tg_tglStart END AS tg_tglStart, CASE WHEN tg.tg_jenis = 1 THEN tg.tg_tglEnd ELSE tpd.tg_tglEnd END AS tg_tglEnd, tg.tg_rute, tp.tp_email, tp.tp_namaDepan, tp.tp_namaBelakang, tp.tp_jenisKelamin, tp.tp_tempatLahir, tp.tp_noHP_1, tp.tp_alamatRumah, tp.created_date, tp.status
            FROM tour_group tg, tour_peserta tp
            LEFT JOIN (SELECT tpd_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd
            ON tp.tpd_kode = tpd.tpd_kode
            WHERE tp.tg_kode = tg.tg_kode
            ORDER BY tp.created_date DESC
            LIMIT " . $view_per_page . " OFFSET " . $offset . "
        ");
        return $query->result();
    }

    function get_page_count($view_per_page) {
        $query = $this->db->query("
            SELECT COUNT(tp.tp_kodePeserta) AS count
            FROM tour_peserta tp
        ");
        return $query->result();
    }

    function follow_up_tour_peserta($data) {
        $this->db->where("tp_kodePeserta", $data["tp_kodePeserta"]);
        $this->db->set("status", 2);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_peserta");
        return $this->db->affected_rows();
    }

    function get_carousel() {
        $this->db->where("status", 1);
        $this->db->order_by("carousel_index", "asc");
        return $this->db->get("carousel")->result();
    }

    function get_carousel_last_index() {
        $this->db->select("carousel_index");
        $this->db->where("status", 1);
        $this->db->order_by("carousel_index", "desc");
        $this->db->limit(1);
        return $this->db->get("carousel")->result();
    }

    function geser_carousel_index() {
        $this->db->where("status", 1);
        $this->db->set("carousel_index", "carousel_index + 1", false);
        $this->db->update("carousel");
    }

    function update_carousel_index($index) {
        $this->db->where("status", 1);
        $this->db->where("carousel_index >=", $index);
        $this->db->set("carousel_index", "carousel_index + 1", false);
        $this->db->update("carousel");
    }

    function update_carousel_index_by_id($data) {
        $this->db->trans_start();

        $this->db->where("carousel_id", $data["carousel_id"]);
        $this->db->select("carousel_index");
        $this->db->limit(1);
        $index = $this->db->get("carousel")->result();
        if (sizeof($index) > 0) {
            $index = $index[0]->carousel_index;

            if ($index != $data["carousel_index"]) {
                if ($index < $data["carousel_index"]) {
                    $this->db->where("carousel_index >", $index);
                    $this->db->where("carousel_index <=", $data["carousel_index"]);
                    $this->db->set("carousel_index", "carousel_index - 1", false);
                    $this->db->update("carousel");
                } else {
                    $this->db->where("carousel_index <", $index);
                    $this->db->where("carousel_index >=", $data["carousel_index"]);
                    $this->db->set("carousel_index", "carousel_index + 1", false);
                    $this->db->update("carousel");
                }

                $this->db->where("carousel_id", $data["carousel_id"]);
                $this->db->set("carousel_index", $data["carousel_index"]);
                $this->db->update("carousel");
            }
        }

        $this->db->trans_complete();
    }

    function update_reverse_carousel_index($index) {
        $this->db->where("status", 1);
        $this->db->where("carousel_index >", $index);
        $this->db->set("carousel_index", "carousel_index - 1", false);
        $this->db->update("carousel");
    }

    function insert_carousel($data) {
        $this->db->trans_start();

        if ($data["carousel_index"] == "first") {
            $this->geser_carousel_index();
            $data["carousel_index"] = 1;
        } else if ($data["carousel_index"] == "last") {
            $last_index = $this->get_carousel_last_index();
            if (sizeof($last_index) > 0) {
                $data["carousel_index"] = intval($last_index[0]->carousel_index) + 1;
            } else {
                $data["carousel_index"] = 1;
            }
        } else {
            $data["carousel_index"] = intval($data["carousel_index"]);
            $this->update_carousel_index($data["carousel_index"]);
        }

        $insertData = array(
            "carousel_text_position" => $data["carousel_text_position"],
            "carousel_title" => $data["carousel_title"],
            "carousel_title_color" => $data["carousel_title_color"],
            "carousel_description" => $data["carousel_description"],
            "carousel_description_color" => $data["carousel_description_color"],
            "carousel_button_color" => $data["carousel_button_color"],
            "carousel_button_text" => $data["carousel_button_text"],
            "carousel_button_link" => $data["carousel_button_link"],
            "carousel_image_extension" => $data["carousel_image_extension"],
            "carousel_image_mobile_extension" => $data["carousel_image_mobile_extension"],
            "carousel_zoom_out" => $data["carousel_zoom_out"],
            "carousel_index" => $data["carousel_index"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("carousel", $insertData);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();
        return $insert_id;
    }

    function get_carousel_by_id($carousel_id) {
        $this->db->where("carousel_id", $carousel_id);
        $this->db->where("status", 1);
        $this->db->limit(1);
        return $this->db->get("carousel")->result();
    }

    function update_carousel($data) {
        $this->db->where("carousel_id", $data["carousel_id"]);
        $this->db->set("carousel_text_position", $data["carousel_text_position"]);
        $this->db->set("carousel_title", $data["carousel_title"]);
        $this->db->set("carousel_title_color", $data["carousel_title_color"]);
        $this->db->set("carousel_description", $data["carousel_description"]);
        $this->db->set("carousel_description_color", $data["carousel_description_color"]);
        $this->db->set("carousel_button_color", $data["carousel_button_color"]);
        $this->db->set("carousel_button_text", $data["carousel_button_text"]);
        $this->db->set("carousel_button_link", $data["carousel_button_link"]);
        $this->db->set("carousel_image_extension", $data["carousel_image_extension"]);
        $this->db->set("carousel_image_mobile_extension", $data["carousel_image_mobile_extension"]);
        $this->db->set("carousel_zoom_out", $data["carousel_zoom_out"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("carousel");
        return $this->db->affected_rows();
    }

    function delete_carousel($data) {
        $this->db->trans_start();

        $this->db->select("carousel_index");
        $this->db->where("carousel_id", $data["carousel_id"]);
        $this->db->limit(1);
        $index = $this->db->get("carousel")->result();

        if (sizeof($index) > 0) {
            $index = $index[0]->carousel_index;
            $this->update_reverse_carousel_index($index);

            $this->db->where("carousel_id", $data["carousel_id"]);
            $this->db->set("status", 0);
            $this->db->set("modified_date", "NOW()", false);
            $this->db->set("modified_by", $data["user_id"]);
            $this->db->update("carousel");
        }

        $this->db->trans_complete();
    }

    function tour_highlight_get() {
        $query = $this->db->query("
            SELECT thi_kode, thi_nama
            FROM tour_highlight
            WHERE status = 1
        ");
        return $query->result();
    }

    function tour_highlight_insert($data) {
        $insertData = array(
            "thi_nama" => $data["thi_nama"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_highlight", $insertData);
        return $this->db->affected_rows();
    }

    function add_tour_highlight($data) {
        $insertData = array(
            "thi_nama" => $data["thi_nama"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_highlight", $insertData);
        return array(
            "thi_kode" => $this->db->insert_id(),
            "thi_nama" => $data["thi_nama"]
        );
    }

    function tour_highlight_update($data) {
        $this->db->where("thi_kode", $data["thi_kode"]);
        $this->db->set("thi_nama", $data["thi_nama"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);

        $this->db->update("tour_highlight");
        return $this->db->affected_rows();
    }

    function tour_highlight_delete($data) {
        $this->db->where("thi_kode", $data["thi_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);

        $this->db->update("tour_highlight");
        return $this->db->affected_rows();
    }

    function tour_bonus_get() {
        $query = $this->db->query("
            SELECT tb_kode, tb_nama
            FROM tour_bonus
            WHERE status = 1
        ");
        return $query->result();
    }

    function tour_bonus_insert($data) {
        $insertData = array(
            "tb_nama" => $data["tb_nama"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_bonus", $insertData);
        return $this->db->affected_rows();
    }

    function add_tour_bonus($data) {
        $insertData = array(
            "tb_nama" => $data["tb_nama"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_bonus", $insertData);
        return array(
            "tb_kode" => $this->db->insert_id(),
            "tb_nama" => $data["tb_nama"]
        );
    }

    function tour_bonus_update($data) {
        $this->db->where("tb_kode", $data["tb_kode"]);
        $this->db->set("tb_nama", $data["tb_nama"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);

        $this->db->update("tour_bonus");
        return $this->db->affected_rows();
    }

    function tour_bonus_delete($data) {
        $this->db->where("tb_kode", $data["tb_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);

        $this->db->update("tour_bonus");
        return $this->db->affected_rows();
    }

    function tour_group_get() {
        $query = $this->db->query("
            SELECT tg_kode, tg_nama, tg_tglStart, tg_tglEnd, tg_rute, tg_pembimbing, tg_image_extension, modified_date
            FROM tour_group
            WHERE status = 1 AND tg_jenis = 1
            ORDER BY tg_tglStart DESC, tg_tglEnd DESC, created_date DESC
        ");
        return $query->result();
    }

    function get_tour_group_by_id($id) {
        $query = $this->db->query("
            SELECT tg.*, tghi.thi_kode, tghi.thi_nama, tgb.tb_kode, tgb.tb_nama
            FROM tour_group tg
            LEFT JOIN (SELECT tghi.tg_kode, GROUP_CONCAT(tghi.thi_kode) AS thi_kode, GROUP_CONCAT(tghi.thi_nama) AS thi_nama FROM (SELECT tghi.tg_kode, tghi.thi_kode, thi.thi_nama FROM tour_group_highlight tghi, tour_highlight thi WHERE tghi.thi_kode = thi.thi_kode AND tghi.tg_kode = '" . $id . "') tghi) tghi
            ON tg.tg_kode = tghi.tg_kode
            LEFT JOIN (SELECT tgb.tg_kode, GROUP_CONCAT(tgb.tb_kode) AS tb_kode, GROUP_CONCAT(tgb.tb_nama) AS tb_nama
            FROM (SELECT tgb.tg_kode, tgb.tb_kode, tb.tb_nama FROM tour_group_bonus tgb, tour_bonus tb WHERE tgb.tb_kode = tb.tb_kode AND tgb.tg_kode = '" . $id . "') tgb) tgb
            ON tg.tg_kode = tgb.tg_kode
            WHERE tg.tg_kode = '" . $id . "'
            LIMIT 1
        ");
        return $query->result();
    }

    function tour_group_insert($data) {
        $this->db->trans_start();

        $insertData = array(
            "tg_jenis_tour" => $data["tg_jenis_tour"],
            "tg_nama" => $data["tour_group_nama"],
            "tg_tglStart" => $data["date_start"],
            "tg_tglEnd" => $data["date_end"],
            "tg_image_extension" => $data["tour_group_image_extension"],
            "tg_durasi" => 1,
            "tg_rute" => $data["rute"],
            "tg_cicilan" => $data["cicilan"],
            "tg_pembimbing" => $data["pembimbing"],
            "tg_include_pax" => $data["include_pax"],
            "tg_exclude_pax" => $data["exclude_pax"],
            "tg_responsibility" => $data["responsibility"],
            "tg_tnc" => $data["tnc"],
            "tg_contactPersonNama1" => $data["cp_name_1"],
            "tg_contactPersonHP1" => $data["cp_hp_1"],
            "tg_contactPersonEmail1" => $data["cp_email_1"],
            "tg_contactPersonNama2" => $data["cp_name_2"],
            "tg_contactPersonHP2" => $data["cp_hp_2"],
            "tg_contactPersonEmail2" => $data["cp_email_2"],
            "tg_jenis" => 1,
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_group", $insertData);
        $tg_kode = $this->db->insert_id();

        $this->tour_group_insert_detail($data, $tg_kode);
        
        $tgi_kode_arr = array();
        for ($i = 0; $i < $data["itinerary_count"]; $i++) {
            $itinerary_image_count = $data["itinerary_item_arr"][$i]["itinerary_image_count"];
            $insertItineraryData = array(
                "tg_kode" => $tg_kode,
                "tgi_tanggal" => $data["itinerary_item_arr"][$i]["itinerary_date"],
                "tgi_place" => $data["itinerary_item_arr"][$i]["itinerary_place"],
                "tgi_remarks" => $data["itinerary_item_arr"][$i]["itinerary_remarks"],
                "tgi_image_count" => $itinerary_image_count,
                "tgi_image_position" => $data["itinerary_item_arr"][$i]["itinerary_image_position"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            );

            for ($j = 1; $j <= $itinerary_image_count; $j++) {
                $insertItineraryData["tgi_image_" . $j . "_extension"] = $data["itinerary_item_arr"][$i]["itinerary_image_" . $j . "_extension"];
            }
            
            $this->db->insert("tour_group_itinerary", $insertItineraryData);
            $tgi_kode = $this->db->insert_id();
            array_push($tgi_kode_arr, $tgi_kode);
        }

        $this->db->trans_complete();

        return array(
            "tg_kode" => $tg_kode,
            "tgi_kode_arr" => $tgi_kode_arr
        );
    }

    function tour_group_insert_detail($data, $tg_kode) {
        $insertDataBatch = array();
        $iLength = sizeof($data["harga_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $tg_kode,
                "tgha_harga" => $data["harga_arr"][$i]["harga"],
                "tgha_kurs" => $data["harga_arr"][$i]["kurs"],
                "tgha_remarks" => $data["harga_arr"][$i]["harga_remarks"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_harga", $insertDataBatch);
        }

        $insertDataBatch = array();
        $iLength = sizeof($data["tour_highlight"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $tg_kode,
                "thi_kode" => $data["tour_highlight"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_highlight", $insertDataBatch);
        }

        $insertDataBatch = array();
        $iLength = sizeof($data["tour_bonus"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $tg_kode,
                "tb_kode" => $data["tour_bonus"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_bonus", $insertDataBatch);
        }
    }

    function get_tour_group_harga_by_id($tg_kode) {
        $this->db->where("tg_kode", $tg_kode);
        return $this->db->get("tour_group_harga")->result();
    }

    function tour_group_update($data) {
        $this->db->trans_start();

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->set("tg_jenis_tour", $data["tg_jenis_tour"]);
        $this->db->set("tg_nama", $data["tour_group_nama"]);
        $this->db->set("tg_tglStart", $data["date_start"]);
        $this->db->set("tg_tglEnd", $data["date_end"]);
        $this->db->set("tg_image_extension", $data["tour_group_image_extension"]);
        $this->db->set("tg_durasi", 1);
        $this->db->set("tg_rute", $data["rute"]);
        $this->db->set("tg_cicilan", $data["cicilan"]);
        $this->db->set("tg_pembimbing", $data["pembimbing"]);
        $this->db->set("tg_include_pax", $data["include_pax"]);
        $this->db->set("tg_exclude_pax", $data["exclude_pax"]);
        $this->db->set("tg_responsibility", $data["responsibility"]);
        $this->db->set("tg_tnc", $data["tnc"]);
        $this->db->set("tg_contactPersonNama1", $data["cp_name_1"]);
        $this->db->set("tg_contactPersonHP1", $data["cp_hp_1"]);
        $this->db->set("tg_contactPersonEmail1", $data["cp_email_1"]);
        $this->db->set("tg_contactPersonNama2", $data["cp_name_2"]);
        $this->db->set("tg_contactPersonHP2", $data["cp_hp_2"]);
        $this->db->set("tg_contactPersonEmail2", $data["cp_email_2"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_group");

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_harga");
        $insertDataBatch = array();
        $iLength = sizeof($data["harga_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "tgha_harga" => $data["harga_arr"][$i]["harga"],
                "tgha_kurs" => $data["harga_arr"][$i]["kurs"],
                "tgha_remarks" => $data["harga_arr"][$i]["harga_remarks"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_harga", $insertDataBatch);
        }

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_highlight");
        $insertDataBatch = array();
        $iLength = sizeof($data["tour_highlight"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "thi_kode" => $data["tour_highlight"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_highlight", $insertDataBatch);
        }

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_bonus");
        $insertDataBatch = array();
        $iLength = sizeof($data["tour_bonus"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "tb_kode" => $data["tour_bonus"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_bonus", $insertDataBatch);
        }
        
        $this->db->trans_complete();
    }

    function tour_package_get() {
        $query = $this->db->query("
            SELECT tg_kode, tg_nama, tg_durasi, tg_rute, tg_pembimbing, tg_image_extension, modified_date
            FROM tour_group
            WHERE status = 1 AND tg_jenis = 2
            ORDER BY created_date DESC
        ");
        return $query->result();
    }

    function tour_package_insert($data) {
        $this->db->trans_start();

        $insertData = array(
            "tg_jenis_tour" => $data["tg_jenis_tour"],
            "tg_nama" => $data["tour_group_nama"],
            "tg_description" => $data["tour_group_description"],
            "tg_image_extension" => $data["tour_group_image_extension"],
            "tg_durasi" => $data["durasi"],
            "tg_rute" => $data["rute"],
            "tg_cicilan" => $data["cicilan"],
            "tg_pembimbing" => $data["pembimbing"],
            "tg_include_pax" => $data["include_pax"],
            "tg_exclude_pax" => $data["exclude_pax"],
            "tg_responsibility" => $data["responsibility"],
            "tg_tnc" => $data["tnc"],
            "tg_contactPersonNama1" => $data["cp_name_1"],
            "tg_contactPersonHP1" => $data["cp_hp_1"],
            "tg_contactPersonEmail1" => $data["cp_email_1"],
            "tg_contactPersonNama2" => $data["cp_name_2"],
            "tg_contactPersonHP2" => $data["cp_hp_2"],
            "tg_contactPersonEmail2" => $data["cp_email_2"],
            "tg_jenis" => 2,
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_group", $insertData);
        $tg_kode = $this->db->insert_id();

        $insertDataBatch = array();
        $iLength = sizeof($data["tanggal_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $tg_kode,
                "tg_tglStart" => $data["tanggal_arr"][$i]["tg_tglStart"],
                "tg_tglEnd" => $data["tanggal_arr"][$i]["tg_tglEnd"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_package_date", $insertDataBatch);
        }

        $this->tour_group_insert_detail($data, $tg_kode);
        
        $tgi_kode_arr = array();
        for ($i = 0; $i < $data["itinerary_count"]; $i++) {
            $itinerary_image_count = $data["itinerary_item_arr"][$i]["itinerary_image_count"];
            $insertItineraryData = array(
                "tg_kode" => $tg_kode,
                "tgi_hari" => $data["itinerary_item_arr"][$i]["itinerary_day"],
                "tgi_place" => $data["itinerary_item_arr"][$i]["itinerary_place"],
                "tgi_remarks" => $data["itinerary_item_arr"][$i]["itinerary_remarks"],
                "tgi_image_count" => $itinerary_image_count,
                "tgi_image_position" => $data["itinerary_item_arr"][$i]["itinerary_image_position"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            );

            for ($j = 1; $j <= $itinerary_image_count; $j++) {
                $insertItineraryData["tgi_image_" . $j . "_extension"] = $data["itinerary_item_arr"][$i]["itinerary_image_" . $j . "_extension"];
            }
            
            $this->db->insert("tour_group_itinerary", $insertItineraryData);
            $tgi_kode = $this->db->insert_id();
            array_push($tgi_kode_arr, $tgi_kode);
        }

        $this->db->trans_complete();

        return array(
            "tg_kode" => $tg_kode,
            "tgi_kode_arr" => $tgi_kode_arr
        );
    }

    function get_tour_package_date_by_id($tg_kode) {
        $this->db->where("tg_kode", $tg_kode);
        return $this->db->get("tour_package_date")->result();
    }

    function tour_package_update($data) {
        $this->db->trans_start();

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->set("tg_jenis_tour", $data["tg_jenis_tour"]);
        $this->db->set("tg_nama", $data["tour_group_nama"]);
        $this->db->set("tg_description", $data["tour_group_description"]);
        $this->db->set("tg_image_extension", $data["tour_group_image_extension"]);
        $this->db->set("tg_durasi", $data["durasi"]);
        $this->db->set("tg_rute", $data["rute"]);
        $this->db->set("tg_cicilan", $data["cicilan"]);
        $this->db->set("tg_pembimbing", $data["pembimbing"]);
        $this->db->set("tg_include_pax", $data["include_pax"]);
        $this->db->set("tg_exclude_pax", $data["exclude_pax"]);
        $this->db->set("tg_responsibility", $data["responsibility"]);
        $this->db->set("tg_tnc", $data["tnc"]);
        $this->db->set("tg_contactPersonNama1", $data["cp_name_1"]);
        $this->db->set("tg_contactPersonHP1", $data["cp_hp_1"]);
        $this->db->set("tg_contactPersonEmail1", $data["cp_email_1"]);
        $this->db->set("tg_contactPersonNama2", $data["cp_name_2"]);
        $this->db->set("tg_contactPersonHP2", $data["cp_hp_2"]);
        $this->db->set("tg_contactPersonEmail2", $data["cp_email_2"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_group");

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_package_date");
        $insertDataBatch = array();
        $iLength = sizeof($data["tanggal_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "tg_tglStart" => $data["tanggal_arr"][$i]["tg_tglStart"],
                "tg_tglEnd" => $data["tanggal_arr"][$i]["tg_tglEnd"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_package_date", $insertDataBatch);
        }

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_harga");
        $insertDataBatch = array();
        $iLength = sizeof($data["harga_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "tgha_harga" => $data["harga_arr"][$i]["harga"],
                "tgha_kurs" => $data["harga_arr"][$i]["kurs"],
                "tgha_remarks" => $data["harga_arr"][$i]["harga_remarks"],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_harga", $insertDataBatch);
        }

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_highlight");
        $insertDataBatch = array();
        $iLength = sizeof($data["tour_highlight"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "thi_kode" => $data["tour_highlight"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_highlight", $insertDataBatch);
        }

        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->delete("tour_group_bonus");
        $insertDataBatch = array();
        $iLength = sizeof($data["tour_bonus"]);
        for ($i = 0; $i < $iLength; $i++) {
            array_push($insertDataBatch, array(
                "tg_kode" => $data["tg_kode"],
                "tb_kode" => $data["tour_bonus"][$i],
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            ));
        }
        if (sizeof($insertDataBatch) > 0) {
            $this->db->insert_batch("tour_group_bonus", $insertDataBatch);
        }
        
        $this->db->trans_complete();
    }

    function delete_tour_group($data) {
        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_group");
        return $this->db->affected_rows();
    }

    function get_itinerary_by_group_id($id) {
        $query = $this->db->query("
            SELECT *
            FROM tour_group_itinerary
            WHERE tg_kode = '" . $id . "' AND status = 1
            ORDER BY tgi_tanggal
        ");
        return $query->result();
    }

    function insert_itinerary($data) {
        $itinerary_image_count = $data["itinerary_image_count"];
        $insertData = array(
            "tg_kode" => $data["tg_kode"],
            "tgi_tanggal" => $data["itinerary_date"],
            "tgi_hari" => $data["itinerary_day"],
            "tgi_place" => $data["itinerary_place"],
            "tgi_remarks" => $data["itinerary_remarks"],
            "tgi_image_count" => $itinerary_image_count,
            "tgi_image_position" => $data["itinerary_image_position"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );

        for ($j = 1; $j <= $itinerary_image_count; $j++) {
            $insertData["tgi_image_" . $j . "_extension"] = $data["itinerary_image_" . $j . "_extension"];
        }
        
        $this->db->insert("tour_group_itinerary", $insertData);
        return $this->db->insert_id();
    }

    function update_itinerary($data) {
        $itinerary_image_count = $data["itinerary_image_count"];

        $this->db->where("tgi_kode", $data["tgi_kode"]);
        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->set("tgi_tanggal", $data["itinerary_date"]);
        $this->db->set("tgi_hari", $data["itinerary_day"]);
        $this->db->set("tgi_place", $data["itinerary_place"]);
        $this->db->set("tgi_remarks", $data["itinerary_remarks"]);
        $this->db->set("tgi_image_count", $itinerary_image_count);
        $this->db->set("tgi_image_position", $data["itinerary_image_position"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        for ($j = 1; $j <= $itinerary_image_count; $j++) {
            $this->db->set("tgi_image_" . $j . "_extension", $data["itinerary_image_" . $j . "_extension"]);
        }
        $this->db->update("tour_group_itinerary");
        return $this->db->affected_rows();
    }

    function delete_itinerary($data) {
        $this->db->where("tg_kode", $data["tg_kode"]);
        $this->db->where("tgi_kode", $data["tgi_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_group_itinerary");
        return $this->db->affected_rows();
    }

    function get_article() {
        $this->db->where("status", 1);
        $this->db->order_by("modified_date", "desc");
        return $this->db->get("tour_article")->result();
    }

    function insert_article($data) {
        $this->db->trans_start();

        $insertData = array(
            "ta_title" => $data["ta_title"],
            "ta_image_extension" => $data["ta_image_extension"],
            "admin_id" => $data["user_id"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_article", $insertData);
        $ta_kode = $this->db->insert_id();

        $tac_image_arr = array();
        $iLength = sizeof($data["content_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            $tac_type = 1;
            $tac_value = "";
            $tac_image_extension = "";

            if ($data["content_arr"][$i]["type"] == "image") {
                $tac_type = 2;
                $tac_image_extension = $data["content_arr"][$i]["content"];
            } else {
                $tac_value = $data["content_arr"][$i]["content"];
            }

            $insertData = array(
                "ta_kode" => $ta_kode,
                "tac_type" => $tac_type,
                "tac_value" => $tac_value,
                "tac_image_extension" => $tac_image_extension,
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            );

            $this->db->insert("tour_article_content", $insertData);
            if ($tac_type == 2) {
                $tac_kode = $this->db->insert_id();
                array_push($tac_image_arr, $tac_kode);
            }
        }

        $this->db->trans_complete();

        return array(
            "ta_kode" => $ta_kode,
            "tac_image_arr" => $tac_image_arr
        );
    }

    function get_article_by_id($ta_kode) {
        $this->db->where("status", 1);
        $this->db->where("ta_kode", $ta_kode);
        $this->db->limit(1);
        return $this->db->get("tour_article")->result();
    }

    function get_article_detail_by_id($ta_kode) {
        $this->db->where("ta_kode", $ta_kode);
        return $this->db->get("tour_article_content")->result();
    }

    function update_article($data) {
        $this->db->trans_start();

        $this->db->where("ta_kode", $data["ta_kode"]);
        $this->db->set("ta_title", $data["ta_title"]);
        $this->db->set("ta_image_extension", $data["ta_image_extension"]);
        $this->db->set("admin_id", $data["user_id"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_article");

        $this->db->where("ta_kode", $data["ta_kode"]);
        $article_content = $this->db->get("tour_article_content")->result();
        $iLength = sizeof($article_content);
        for ($i = 0; $i < $iLength; $i++) {
            if ($article_content[$i]->tac_type == 2) {
                $image_url = "assets/images/article/article_content_" . $article_content[$i]->tac_kode . "." . $article_content[$i]->tac_image_extension;
                if (file_exists($image_url)) {
                    unlink($image_url);
                }
            }
        }

        $this->db->where("ta_kode", $data["ta_kode"]);
        $this->db->delete("tour_article_content");

        $tac_image_arr = array();
        $iLength = sizeof($data["content_arr"]);
        for ($i = 0; $i < $iLength; $i++) {
            $tac_type = 1;
            $tac_value = "";
            $tac_image_extension = "";

            if ($data["content_arr"][$i]["type"] == "image") {
                $tac_type = 2;
                $tac_image_extension = $data["content_arr"][$i]["content"];
            } else {
                $tac_value = $data["content_arr"][$i]["content"];
            }

            $insertData = array(
                "ta_kode" => $data["ta_kode"],
                "tac_type" => $tac_type,
                "tac_value" => $tac_value,
                "tac_image_extension" => $tac_image_extension,
                "created_by" => $data["user_id"],
                "modified_by" => $data["user_id"]
            );

            $this->db->insert("tour_article_content", $insertData);
            if ($tac_type == 2) {
                $tac_kode = $this->db->insert_id();
                array_push($tac_image_arr, $tac_kode);
            }
        }

        $this->db->trans_complete();

        return array(
            "tac_image_arr" => $tac_image_arr
        );
    }

    function delete_article($data) {
        $this->db->where("ta_kode", $data["ta_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_article");
        return $this->db->affected_rows();
    }

    function get_services() {
        $this->db->where("status", 1);
        $this->db->order_by("created_date", "desc");
        return $this->db->get("tour_service")->result();
    }

    function get_service_by_id($ts_kode) {
        $query = $this->db->query("
            SELECT *
            FROM tour_service
            WHERE ts_kode = '" . $ts_kode . "' AND status = 1
            LIMIT 1
        ");
        return $query->result();
    }

    function insert_service($data) {
        $insertData = array(
            "ts_nama" => $data["ts_nama"],
            "ts_image_extension" => $data["ts_image_extension"],
            "ts_keterangan" => $data["ts_keterangan"],
            "created_by" => $data["user_id"],
            "modified_by" => $data["user_id"]
        );
        $this->db->insert("tour_service", $insertData);
        return $this->db->insert_id();
    }

    function update_service($data) {
        $this->db->where("ts_kode", $data["ts_kode"]);
        $this->db->set("ts_nama", $data["ts_nama"]);
        $this->db->set("ts_image_extension", $data["ts_image_extension"]);
        $this->db->set("ts_keterangan", $data["ts_keterangan"]);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_service");
        return $this->db->affected_rows();
    }

    function delete_service($data) {
        $this->db->where("ts_kode", $data["ts_kode"]);
        $this->db->set("status", 0);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["user_id"]);
        $this->db->update("tour_service");
        return $this->db->affected_rows();
    }

    public function get_password() {
        $this->db->select("admin_password");
        return $this->db->get("admin")->result()[0];
    }

    public function update_password($password) {
        $this->db->set("admin_password", $password);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->update("admin");
    }
}
