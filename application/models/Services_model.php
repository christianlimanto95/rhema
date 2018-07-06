<?php

class Services_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_services() {
        $this->db->select("ts_kode, ts_nama, ts_image_extension, ts_keterangan, modified_date");
        $this->db->where("status", 1);
        $this->db->order_by("created_date", "desc");
        return $this->db->get("tour_service")->result();
    }
}
