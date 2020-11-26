<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class News extends CI_Controller {

        function __construct(){
            parent::__construct();
            $this->load->model("Model_news", "mNews");
        }

        public function index(){
            $data = array("title" => "Dashboard CRM");
            $this->template->display('NewsList_view', $data);
        }

        public function detail(){
            $data = array("title" => "Dashboard CRM");
            $this->template->display('NewsDetail_view', $data);
        }

        public function getNews($idNews = null){
            $news = $this->mNews->getNews($idNews);
            if($news){
                foreach ($news as $newsKey => $newsValue) {
                    $data["id_artikel"] = $newsValue->ID_ARTIKEL;
                    $data["title"] = $newsValue->TITLE;
                    $data["public_date"] = $newsValue->PUP_DATE;
                    $data["thumbnail"] = $newsValue->THUMBNAIL;
                    $data["content"] = str_replace('\\n', '<br/>&nbsp;<br/>', $newsValue->CONTENT_1).str_replace('\\n', '<br/>&nbsp;<br/>', $newsValue->CONTENT_2).str_replace('\\n', '<br/>&nbsp;<br/>', $newsValue->CONTENT_3);

                    $json[] = $data;
                }
            }
            echo json_encode(array("status" => "success", "data" => $json));
        }

    }
?>