<?php

class Register_tour_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_tour_group($page, $view_per_page) {
        $offset = ($page - 1) * $view_per_page;
        $query = $this->db->query("
            SELECT a.*
            FROM
                (SELECT tg.tg_kode, tg.tg_nama, tg.tg_jenis, NULL AS tpd_kode, tg.tg_tglStart, tg.tg_tglEnd, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
                FROM tour_group tg
                LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
                ON tg.tg_kode = tgha.tg_kode
                WHERE tg.status = 1 AND tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()) a
            UNION ALL
            SELECT b.*
            FROM
                (SELECT tg.tg_kode, tg.tg_nama, tg.tg_jenis, tpd.tpd_kode, tpd.tg_tglStart, tpd.tg_tglEnd, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
                FROM (SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd, tour_group tg
                LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
                ON tg.tg_kode = tgha.tg_kode
                WHERE tg.status = 1 AND tg.tg_jenis = 2 AND tg.tg_kode = tpd.tg_kode AND tpd.tg_tglStart > CURDATE()) b
            ORDER BY tg_tglStart
            LIMIT " . $view_per_page . " OFFSET " . $offset . "
        ");
        return $query->result();
    }

    public function get_tour_group_count() {
        $query = $this->db->query("
            SELECT COUNT(c.tg_kode) AS count
            FROM (SELECT a.*
                FROM
                    (SELECT tg.tg_kode
                    FROM tour_group tg
                    WHERE tg.status = 1 AND tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()) a
                UNION ALL
                SELECT b.*
                FROM
                    (SELECT tg.tg_kode
                    FROM (SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd, tour_group tg
                    WHERE tg.status = 1 AND tg.tg_jenis = 2 AND tg.tg_kode = tpd.tg_kode AND tpd.tg_tglStart > CURDATE()) b) c
        ");
        return $query->result();
    }

    public function get_tour_group_query($data, $page, $view_per_page) {
        $offset = ($page - 1) * $view_per_page;

        $where_month = "";
        if ($data["month"] != "all") {
            $where_month = " AND MONTH(tg.tg_tglStart) = '" . $data["month"] . "'";
        }

        $where_year = "";
        if ($data["year"] != "all") {
            $where_year = " AND YEAR(tg.tg_tglStart) = '" . $data["year"] . "'";
        }

        $where_tour = "";
        if ($data["tour"] != "") {
            $where_tour = " AND (tg.tg_nama LIKE '%" . $data["tour"] . "%' OR tg.tg_rute LIKE '%" . $data["tour"] . "%' OR tg.tg_pembimbing LIKE '%" . $data["tour"] . "%')";
        }

        $query = $this->db->query("
            SELECT a.*
            FROM
                (SELECT tg.tg_kode, tg.tg_nama, tg.tg_jenis, NULL AS tpd_kode, tg.tg_tglStart, tg.tg_tglEnd, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
                FROM tour_group tg
                LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
                ON tg.tg_kode = tgha.tg_kode
                WHERE tg.status = 1 AND tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()" . $where_month . $where_year . $where_tour . ") a
            UNION ALL
            SELECT b.*
            FROM
                (SELECT tg.tg_kode, tg.tg_nama, tg.tg_jenis, tpd.tpd_kode, tpd.tg_tglStart, tpd.tg_tglEnd, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
                FROM (SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd, tour_group tg
                LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
                ON tg.tg_kode = tgha.tg_kode
                WHERE tg.status = 1 AND tg.tg_jenis = 2 AND tg.tg_kode = tpd.tg_kode AND tpd.tg_tglStart > CURDATE()" . $where_month . $where_year . $where_tour . ") b
            ORDER BY tg_tglStart
            LIMIT " . $view_per_page . " OFFSET " . $offset . "
        ");
        return $query->result();
    }

    public function get_tour_group_query_count($data) {
        $where_month = "";
        if ($data["month"] != "all") {
            $where_month = " AND MONTH(tg.tg_tglStart) = '" . $data["month"] . "'";
        }

        $where_year = "";
        if ($data["year"] != "all") {
            $where_year = " AND YEAR(tg.tg_tglStart) = '" . $data["year"] . "'";
        }

        $where_tour = "";
        if ($data["tour"] != "") {
            $where_tour = " AND (tg.tg_nama LIKE '%" . $data["tour"] . "%' OR tg.tg_rute LIKE '%" . $data["tour"] . "%' OR tg.tg_pembimbing LIKE '%" . $data["tour"] . "%')";
        }

        $query = $this->db->query("
            SELECT COUNT(c.tg_kode) AS count
            FROM (SELECT a.*
                FROM
                    (SELECT tg.tg_kode
                    FROM tour_group tg
                    WHERE tg.status = 1 AND tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()" . $where_month . $where_year . $where_tour . ") a
                UNION ALL
                SELECT b.*
                FROM
                    (SELECT tg.tg_kode
                    FROM (SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd, tour_group tg
                    WHERE tg.status = 1 AND tg.tg_jenis = 2 AND tg.tg_kode = tpd.tg_kode AND tpd.tg_tglStart > CURDATE()" . $where_month . $where_year . $where_tour . ") b) c
        ");
        return $query->result();
    }

    public function get_tour_group_by_id($tg_kode) {
        $query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_description, tg.tg_image_extension, tg.tg_tglStart, tg.tg_tglEnd, tg.tg_rute, tg.tg_pembimbing, tg.tg_include_pax, tg.tg_exclude_pax, tg.tg_responsibility, tg.tg_tnc, tg.tg_contactPersonNama1, tg.tg_contactPersonHP1, tg.tg_contactPersonEmail1, tg.tg_contactPersonNama2, tg.tg_contactPersonHP2, tg.tg_contactPersonEmail2, tg_cicilan, tg.tg_jenis, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
            FROM tour_group tg
            LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
            ON tg.tg_kode = tgha.tg_kode
            WHERE tg.tg_kode = '" . $tg_kode . "' AND tg.status = 1 AND ((tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()) OR (tg.tg_jenis = 2))
            ORDER BY tg.tg_tglStart
            LIMIT 1
        ");
        return $query->result();
    }

    public function get_tour_group_itinerary($tg_kode) {
        $query = $this->db->query("
            SELECT tgi_kode, tgi_tanggal, tgi_place, tgi_remarks, tgi_image_1_extension, tgi_image_2_extension, tgi_image_3_extension, tgi_image_count, tgi_image_position, modified_date
            FROM tour_group_itinerary
            WHERE tg_kode = '" . $tg_kode . "' AND status = 1
        ");
        return $query->result();
    }

    public function get_tour_group_highlight($tg_kode) {
        $query = $this->db->query("
            SELECT tghi.thi_kode, thi.thi_nama
            FROM tour_group_highlight tghi, tour_highlight thi
            WHERE tghi.tg_kode = '" . $tg_kode . "' AND tghi.thi_kode = thi.thi_kode
        ");
        return $query->result();
    }

    public function get_tour_group_bonus($tg_kode) {
        $query = $this->db->query("
            SELECT tgb.tb_kode, tb.tb_nama
            FROM tour_group_bonus tgb, tour_bonus tb
            WHERE tgb.tg_kode = '" . $tg_kode . "' AND tgb.tb_kode = tb.tb_kode
        ");
        return $query->result();
    }

    public function get_tour_package_date($tg_kode) {
        $query = $this->db->query("
            SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd
            FROM tour_package_date
            WHERE tg_kode = '" . $tg_kode . "'
        ");
        return $query->result();
    }

    public function insert_tour_peserta($data) {
        if ($data["tg_jenis"] == "1") {
            $insertData = array(
                "tg_kode" => $data["tg_kode"],
                "tp_email" => $data["tp_email"],
                "tp_namaDepan" => $data["tp_namaDepan"],
                "tp_jenisKelamin" => $data["tp_jenisKelamin"],
                "tp_noHP_1" => $data["tp_noHP_1"],
                "created_by" => 0,
                "modified_by" => 0
            );
            $this->db->insert("tour_peserta", $insertData);
        } else {
            $insertData = array(
                "tg_kode" => $data["tg_kode"],
                "tpd_kode" => $data["tpd_kode"],
                "tp_email" => $data["tp_email"],
                "tp_namaDepan" => $data["tp_namaDepan"],
                "tp_jenisKelamin" => $data["tp_jenisKelamin"],
                "tp_noHP_1" => $data["tp_noHP_1"],
                "created_by" => 0,
                "modified_by" => 0
            );
            $this->db->insert("tour_peserta", $insertData);
        }
        return $this->db->affected_rows();
    }
}
