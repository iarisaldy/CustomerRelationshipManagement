<?php
    class Model_news extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function getNews($idNews = null){
            if(isset($idNews)){
                $this->db->where("ID_ARTIKEL", $idNews);
            }
            $this->db->select("ID_ARTIKEL, TITLE, PUP_DATE, THUMBNAIL, CONTENT_1, CONTENT_2, CONTENT_3");
            $this->db->from("CRMNEW_NEWS");
            $this->db->order_by("PUP_DATE", "DESC");
            $news = $this->db->get();
			// echo $this->db->last_query();
			// exit;
            if($news->num_rows() > 0){
                return $news->result();
            } else {
                return false;
            }
        }
    }
?>