<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class News extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('News_model');
        set_time_limit(0);
    }
    public function index(){
        echo "i love";
    }

    public function Get_data(){
        $rss_url = 'https://semenindonesia.com/rss';
        $api_endpoint = 'https://api.rss2json.com/v1/api.json?rss_url=';
        $data = json_decode( file_get_contents($api_endpoint . urlencode($rss_url)) , true );

        $hasil = array();

        $n=0;
        foreach ($data['items'] as $d){
            $hasil[$n]['TITLE']         = $d['title'];
            $hasil[$n]['PUP_DATE']      = $d['pubDate'];
            $hasil[$n]['LINK']          = $d['link'];
            $hasil[$n]['GUID']          = $d['link'];
            $hasil[$n]['AUTHOR']        = $d['link'];
            $hasil[$n]['THUMBNAIL']     = $d['thumbnail'];
			
			$content = trim(strip_tags($d['content']), "\n");
			$hasil[$n]['CONTENT1'] = $content;
			$hasil[$n]['CONTENT']		= substr($content,0, 3000);
			$hasil[$n]['CONTENT_2'] 	= substr($content,3000, 3000);
			$hasil[$n]['CONTENT_3'] 	= substr($content,6000, 3000);
			
			/*
			$arr = str_split(trim(strip_tags($d['content']), "\n"), 3000);
			if(count($arr)==1){
				$hasil[$n]['CONTENT'] 		= $arr[0];
				$hasil[$n]['CONTENT_2'] 	= null;
				$hasil[$n]['CONTENT_3'] 	= null;
				
			}
			else if(count($arr)==2){
				$hasil[$n]['CONTENT'] 		= $arr[0];
				$hasil[$n]['CONTENT_2'] 	= $arr[1];
				$hasil[$n]['CONTENT_3'] 	= null;
			}
			else {
				$hasil[$n]['CONTENT'] 		= $arr[0];
				$hasil[$n]['CONTENT_2'] 	= $arr[1];
				$hasil[$n]['CONTENT_3'] 	= $arr[2];
			}
			*/
						
            $hasil[$n]['DISCRIPTION']   = trim(strip_tags($d['description']), "\n");
           // $hasil[$n]['CONTENT']       = trim(strip_tags($d['content']), "\n");
            $hasil[$n]['CREATE_BY']     = 'SCHEDULLER';
            $hasil[$n]['CREATE_DATE']   = date('d-M-y h.s.i A');
            $hasil[$n]['DELETE_MARK']   = 0;
            $n=$n+1;
			
        }
		echo '<pre>';
		//print_r($hasil);
		echo '</pre>';

		$cek = $this->News_model->Insert_artikel($hasil);

        
        //if($cek){
            //print_r($hasil);
        //}
        //else {
        //    echo "ERROR";
        //}
    }
}

?>