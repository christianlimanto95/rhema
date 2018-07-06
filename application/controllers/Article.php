<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include general controller supaya bisa extends General_controller
require_once("application/core/General_controller.php");

class Article extends General_controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Article_model");
	}
	
	public function index()
	{
        $articles = $this->Article_model->get_article();
        parent::set_header_menu_active("article");
		$data = array(
            "title" => "Rhema Tours &mdash; Article",
            "meta_description" => "Article | Life Changing Trip to The Holyland",
            "data" => $articles
		);
		
		parent::view("article", $data);
    }
    
    public function detail() {
        $id = $this->uri->segment(3);
        $article = $this->Article_model->get_article_by_id($id);
        if (sizeof($article) > 0) {
            $detail = $this->Article_model->get_article_detail($id);
            parent::set_header_menu_active("article");
            $data = array(
                "title" => $article[0]->ta_title . " &mdash; Rhema Tours",
                "article" => $article[0],
                "detail" => $detail
            );
            
            parent::view("article_detail", $data);
        } else {
            redirect(base_url("article"));
        }
    }
}
