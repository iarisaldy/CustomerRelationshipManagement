<?php

error_reporting(0);
defined('BASEPATH') or
        exit('No Direct Script Access Allowed');

class RssParse extends CI_Controller {

    private $parser;

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->load->model('RssParse_model');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->library('LastRSS');
        $this->parser = new LastRSS();
    }

    function parseLink() {
        $data = $this->RssParse_model->getLink();
        $keywordRaw = $this->RssParse_model->getKeyword();
        $keyword = array();
        foreach ($keywordRaw as $value) {
            array_push($keyword, $value['KEYWORD']);
        }
        $result = array();
        foreach ($data as $value) {
            $items = $this->parser->get($value['LINK']);

            array_push($result, $this->getKeywordMatch($keyword, $items['items']));
        }
        $save = $this->saveNews($result);
        echo json_encode(array("status" => $save));
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
    }

    function getKeywordMatch($keyword = array(), $teks = array()) {
        $result = array();
        foreach ($keyword as $value) {
            foreach ($teks as $teksValue) {
                if ($this->isKeywordMatch($value, $teksValue['title']) || $this->isKeywordMatch($value, $teksValue['description'])) {
                    if(!$teksValue['pubDate']){
                        $pubdate = date('Y-m-d H:i:s');
                    } else {
                        $pubdate = date('Y-m-d H:i:s', strtotime($teksValue['pubDate']));
                    }
                    array_push($result, array(
                        "title" => $teksValue['title'],
                        "description" => $teksValue['description'],
                        "link" => $teksValue['link'],
                        "pubdate" => $pubdate
                            )
                    );
                }
            }
        }
        return $result;
    }

    /*
     * fungsi untuk mencari kata kunci pada $teks
     */

    function isKeywordMatch($keyword, $teks) {
        if (preg_match("/" . $keyword . "/i", $teks)) {
            return true;
        } else {
            return false;
        }
    }

    function saveNews($data) {
        foreach ($data as $dValue) {
            foreach ($dValue as $value) {
                if (array_key_exists("title", $value)) {
                    if (!$this->cekData($value['link'])) {
                        $dataSave = array(
                            "TITLE" => $this->getTitle($value["title"]),
                            "DESCRIPTION" => $this->cleanQuote(html_escape($value['description'])),
                            "LINK" => $value['link'],
                            "PUBDATE" => $value['pubdate']
                        );
                        $this->RssParse_model->saveNews($dataSave);
//                        echo '<pre>';
//                        print_r($dataSave);
//                        echo '</pre>';
                    }
                }
            }
        }
        return true;
    }

    function clean($string) {
        $string = str_replace('CDATA', '', $string);

        return preg_replace('/[^A-Za-z0-9\ ]/', '', $string); // Removes special chars.
    }

    function cleanQuote($string) {
        $string = str_replace('\'', '', $string); // remove quote.

        return $string;
    }

    function getTitle($string) {
        $string = htmlspecialchars($string);
        $posisiawal = strrpos($string, "[");
        $posisiakhir = strpos($string, "]");

        if ($posisiawal) {
            $title = substr($string, $posisiawal, $posisiakhir - $posisiawal);
            return $this->clean($title);
        } else {
            return $this->clean($string);
        }
    }

    function cekData($link) {
        $cek = $this->RssParse_model->cekLink($link);
        if ($cek > 0) {
            return true;
        } else {
            return false;
        }
    }

    function viewNews() {
        $data = array(
            'title' => 'Cement Newsfeed'
        );
        $this->template->display('News_view', $data);
    }

    function getDataNews() {
        $list = $this->RssParse_model->getNews();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $news) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $news->TITLE;
            $row[] = '<a href="' . $news->LINK . '" target="_blank">' . $news->LINK . '</a>';
            $row[] = $news->PUBDATE;
            if ($news->TAMPIL == 1) {
                $row[] = '<center>'
                        . '<button class="btn btn-xs btn-primary" title="Hide" onclick="sembunyikan(' . $news->ID . ')"><i class="fa fa-eye"></i></button>'
                        . '</center>';
            } else if ($news->TAMPIL == 0) {
                $row[] = '<center>'
                        . '<button class="btn btn-xs btn-default" title="Show" onclick="tampilkan(' . $news->ID . ')"><i class="fa fa-eye-slash"></i></button>'
                        . '</center>';
            }
            $row[] = '<center>'
                    . '<button class="btn btn-xs btn-danger" onclick="hapus(' . $news->ID . ')"><i class="fa fa-trash"></i> Delete</button>'
                    . '</center>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->RssParse_model->countNews(),
            "recordsFiltered" => $this->RssParse_model->filterNews(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function getDataNewsSidebar() {
        $data = $this->RssParse_model->getNewsSidebar();

        foreach ($data as $key => $value) {
            $news = $data[$key]['DESCRIPTION'];
            $news = str_replace('&amp;quot;', '"', $news);
            $news = str_replace('&quot;', '"', $news);
            $news = str_replace('&amp;lt;', '<', $news);
            $news = str_replace('&lt;', '<', $news);
            $news = str_replace('&amp;gt;', '>', $news);
            $news = str_replace('&gt;', '>', $news);
//            $data[$key]['DESCRIPTION'] = html_entity_decode($data[$key]['DESCRIPTION']);
            $data[$key]['DESCRIPTION'] = $news;
        }
        echo json_encode($data);
    }

    function deleteNews() {
        $post = $this->input->post(null, true);

        $delete = $this->RssParse_model->delete($post['id']);

        echo json_encode(array("status" => $delete));
    }

    function showNews() {
        $post = $this->input->post(null, true);

        $show = $this->RssParse_model->show($post['id']);

        echo json_encode(array("status" => $show));
    }

    function hideNews() {
        $post = $this->input->post(null, true);

        $show = $this->RssParse_model->hide($post['id']);

        echo json_encode(array("status" => $show));
    }

}
