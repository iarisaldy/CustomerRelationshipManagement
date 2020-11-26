<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

    class News extends CI_Controller {

        function __construct(){
            parent::__construct();
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
            $rss_url = 'https://semenindonesia.com/rss';
            $api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';
            $xml = json_decode(file_get_contents($api_endpoint.urlencode($rss_url)),true);
            if(isset($idNews)){
            	$id = (int)$idNews;
            	$data["title"] = $xml["items"][$id]["title"];
            	$data["public_date"] = $xml["items"][$id]["pubDate"];
            	$data["content"] = $xml["items"][$id]["content"];
            	$json[] = $data;
            } else {
            	foreach ($xml["items"] as $key => $value) {
	                $data["title"] = $value["title"];
	                $data["public_date"] = $value["pubDate"];
                    $data["content"] = strip_tags($value["content"]);
	                $json[] = $data;
	            }
            }

            echo json_encode(array("status" => "success", "data" => $json));
        }

    }
?>