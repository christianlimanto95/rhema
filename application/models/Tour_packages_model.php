<?php

class Tour_packages_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_tour_package() {
        $query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_image_extension, tg.modified_date
            FROM tour_group tg
            WHERE tg.status = 1 AND tg.tg_jenis = 2
            ORDER BY tg.created_date
        ");
        return $query->result();
    }

    public function get_tour_package_by_id($tg_kode) {
        $query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_description, tg_tglStarts, tg_tglEnds, tg.tg_durasi, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.tg_include_pax, tg.tg_exclude_pax, tg.tg_contactPersonNama1, tg.tg_contactPersonHP1, tg.tg_contactPersonEmail1, tg.tg_contactPersonNama2, tg.tg_contactPersonHP2, tg.tg_contactPersonEmail2, tg.tg_cicilan, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
            FROM tour_group tg
            LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
            ON tg.tg_kode = tgha.tg_kode
            LEFT JOIN (SELECT tg_kode, GROUP_CONCAT(tg_tglStart) AS tg_tglStarts, GROUP_CONCAT(tg_tglEnd) AS tg_tglEnds FROM tour_package_date GROUP BY tg_kode) tpd
            ON tg.tg_kode = tpd.tg_kode
            WHERE tg.tg_kode = '" . $tg_kode . "' AND tg.status = 1 AND tg.tg_jenis = 2
            LIMIT 1
        ");
        return $query->result();
    }

    public function get_tour_package_itinerary($tg_kode) {
        $query = $this->db->query("
            SELECT tgi_kode, tgi_hari, tgi_place, tgi_remarks, tgi_image_1_extension, tgi_image_2_extension, tgi_image_3_extension, tgi_image_count, tgi_image_position, modified_date
            FROM tour_group_itinerary
            WHERE tg_kode = '" . $tg_kode . "' AND status = 1
        ");
        return $query->result();
    }

    public function get_tour_package_highlight($tg_kode) {
        $query = $this->db->query("
            SELECT tghi.thi_kode, thi.thi_nama
            FROM tour_group_highlight tghi, tour_highlight thi
            WHERE tghi.tg_kode = '" . $tg_kode . "' AND tghi.thi_kode = thi.thi_kode
        ");
        return $query->result();
    }

    public function get_tour_package_bonus($tg_kode) {
        $query = $this->db->query("
            SELECT tgb.tb_kode, tb.tb_nama
            FROM tour_group_bonus tgb, tour_bonus tb
            WHERE tgb.tg_kode = '" . $tg_kode . "' AND tgb.tb_kode = tb.tb_kode
        ");
        return $query->result();
    }
}
