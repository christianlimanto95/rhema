<?php

class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_data($username) {
        $this->db->where("admin_username", $username);
        $this->db->select("admin_id, admin_password");
        $this->db->limit(1);
        return $this->db->get("admin")->result();
    }

    function get_password($admin_id) {
        $this->db->where("admin_id", $admin_id);
        $this->db->select("admin_password");
        $this->db->limit(1);
        return $this->db->get("admin")->result();
    }

    function change_password($data) {
        $data["new_password"] = password_hash($data["new_password"], PASSWORD_DEFAULT);
        $this->db->where("admin_id", $data["admin_id"]);
        $this->db->set("admin_password", $data["new_password"], true);
        $this->db->set("modified_date", "NOW()", false);
        $this->db->set("modified_by", $data["admin_id"], true);
        $this->db->update("admin");
        return $this->db->affected_rows();
    }
}
