<?php

class Article_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_article() {
        $query = $this->db->query("
            SELECT ta.ta_kode, ta.ta_title, ta.ta_image_extension, tac.tac_value, ta.modified_date
            FROM tour_article ta
            LEFT JOIN (SELECT ta_kode, tac_value FROM tour_article_content WHERE tac_type = 1) tac
            ON ta.ta_kode = tac.ta_kode
            WHERE ta.status = 1
            GROUP BY ta.ta_kode
            ORDER BY ta.ta_tanggal DESC
        ");
        return $query->result();
    }
    
    function get_article_by_id($ta_kode) {
        $query = $this->db->query("
            SELECT ta_kode, ta_title, ta_image_extension, ta_tanggal, modified_date
            FROM tour_article ta
            WHERE ta_kode = '" . $ta_kode . "'
            LIMIT 1
        ");
        return $query->result();
    }

    function get_article_detail($ta_kode) {
        $query = $this->db->query("
            SELECT tac_kode, tac_type, tac_value, tac_image_extension, modified_date
            FROM tour_article_content
            WHERE ta_kode = '" . $ta_kode . "'
        ");
        return $query->result();
    }
}
