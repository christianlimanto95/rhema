<?php

class Home_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_carousel() {
        $query = $this->db->query("
            SELECT *
            FROM carousel
            WHERE status = 1
            ORDER BY carousel_index ASC
        ");
        return $query->result();
    }

    public function get_tour_package() {
        $query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_image_extension, tg.modified_date
            FROM tour_group tg
            WHERE tg.status = 1 AND tg.tg_jenis = 2
            ORDER BY tg.created_date
            LIMIT 4
        ");

        /*$query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_jenis, tpd.tpd_kode, tpd.tg_tglStart, tpd.tg_tglEnd, tg.tg_image_extension, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
            FROM (SELECT tpd_kode, tg_kode, tg_tglStart, tg_tglEnd FROM tour_package_date) tpd, tour_group tg
            LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
            ON tg.tg_kode = tgha.tg_kode
            WHERE tg.status = 1 AND tg.tg_jenis = 2 AND tg.tg_kode = tpd.tg_kode AND tpd.tg_tglStart > CURDATE()
            ORDER BY tg_tglStart
            LIMIT 4
        ");*/
        return $query->result();
    }

    public function get_tour_group() {
        /*$query = $this->db->query("
            SELECT tg.tg_kode, tg.tg_nama, tg.tg_image_extension, tg.tg_tglStart, tg.tg_tglEnd, tg.tg_rute, tg.tg_pembimbing, tg.modified_date, tgha.tgha_harga, tgha.tgha_kurs
            FROM tour_group tg
            LEFT JOIN (SELECT tg_kode, MIN(tgha_harga) AS tgha_harga, tgha_kurs FROM tour_group_harga GROUP BY tg_kode) tgha
            ON tg.tg_kode = tgha.tg_kode
            WHERE tg.status = 1 AND tg.tg_jenis = 1 AND tg.tg_tglStart > CURDATE()
            ORDER BY tg.tg_tglStart
            LIMIT 4
        ");*/
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
            LIMIT 4
        ");
        return $query->result();
    }
}
