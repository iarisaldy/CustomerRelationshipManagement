<?php
if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

class Target_selling_out extends CI_Controller {

    function __construct()
	{
        parent::__construct();
        $this->load->model('M_target_selling_out');
    }
	
	public function index()
	{
		$data = array("title"=>"Target Selling Out");
		
		// $data['areas'] = $this->M_target_selling_out->get_area();
		// $data['radius_areas'] = $this->M_target_selling_out->get_data();
		
		$this->template->display('target_selling_out', $data);
    }
	
	public function distributor()
	{
		$data = array("title"=>"Target KPI Distributor");
		$this->template->display('target_selling_out_distributor', $data);
    }
	
	public function salesman()
	{
		$data = array("title"=>"Target KPI Salesman");
		$this->template->display('target_selling_out_salesman', $data);
    }
	
	 public function get_data()
    { 
        $s = $this->input->post('search') != null ? $this->input->post('search')["value"] : "";
		$p = $this->input->post('start') != null && $this->input->post('start') != "" && is_numeric($this->input->post('start')) ? intval($this->input->post('start')) : 0;
		$e = $this->input->post('length') != null && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("ID", "ID", "AM", "AM", "VOLUME", "REVENUE", "CA", "VISIT", "NOO", "MARKET_SHARE", "CREATE_BY", "CREATE_DATE", "UPDATE_BY", "UPDATE_DATE");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$hasil = $this->M_target_selling_out->get_data($s, $p, $e, $c, $o);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$baris = 0;
		
		foreach($hasil["data"] as $r) {
			$tombol = array(
				"<button onclick='edit({$baris})' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></button>",
				"<button onclick='konfirmasi({$baris})' class='btn btn-danger'><i class='glyphicon glyphicon-remove'></i></button>"
			);
			$result["data"][] = array(
				htmlspecialchars($baris+1),
				htmlspecialchars($r["ID"]),
				htmlspecialchars($r["AM"]),
				htmlspecialchars($r["NAMA_USER"]. " ( ".$r["AM"]." )"),
				htmlspecialchars($r["VOLUME"]),
				htmlspecialchars($r["REVENUE"]),
				htmlspecialchars($r["CA"]),
				htmlspecialchars($r["VISIT_TARGET"]),
				htmlspecialchars($r["NOO"]),
				htmlspecialchars($r["MARKET_SHARE"]),
				htmlspecialchars($r["CREATE_BY"]),
				htmlspecialchars($r["CREATE_DATE"]),
				htmlspecialchars($r["UPDATE_BY"]),
				htmlspecialchars($r["UPDATE_DATE"]),
				"<center>{$tombol[0]}&nbsp;{$tombol[1]}</center>"
			);
			$baris++;
		}
		echo json_encode($result);

    }
	
	public function get_data_salesman(){

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

		$disabled = 'disabled';
		if ($id_jenis_user == '1012') {
			$disabled = '';
		}

		// print_r('<pre>');
		// print_r($id_user.' - '.$id_jenis_user);exit;

        $s = $this->input->post('search') != null ? $this->input->post('search')["value"] : "";
		$p = $this->input->post('start') != null && $this->input->post('start') != "" && is_numeric($this->input->post('start')) ? intval($this->input->post('start')) : 0;
		$e = $this->input->post('length') != null && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("ID", "ID", "ID_SALES", "ID_SALES", "TOKO_UNIT", "VISIT", "TOKO_AKTIF", "TOKO_BARU", "SELL_OUT_SDG", "SELL_OUT_BK", "CREATE_BY", "CREATE_DATE", "UPDATE_BY", "UPDATE_DATE");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$hasil = $this->M_target_selling_out->get_data_salesman($s, $p, $e, $c, $o, $id_user, $id_jenis_user);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$baris = 0;
		
		foreach($hasil["data"] as $r) {
			
			$tombol = array(
				"<button onclick='edit({$baris})' class='btn btn-warning' $disabled><i class='glyphicon glyphicon-pencil'></i></button>",
				"<button onclick='konfirmasi({$baris})' class='btn btn-danger' $disabled><i class='glyphicon glyphicon-remove'></i></button>"
			);

			$aksi = "<center>{$tombol[0]}&nbsp;{$tombol[1]}</center>";

			$result["data"][] = array(
				htmlspecialchars($baris+1),
				htmlspecialchars($r["ID"]),
				htmlspecialchars($r["ID_SALES"]),
				htmlspecialchars($r["NAMA_USER"]. " ( ".$r["ID_SALES"]." )"),
				htmlspecialchars($r["TOKO_UNIT"]),
				htmlspecialchars($r["VISIT_TARGET"]),
				htmlspecialchars($r["TOKO_AKTIF"]),
				htmlspecialchars($r["TOKO_BARU"]),
				htmlspecialchars($r["SELL_OUT_SDG"]),
				htmlspecialchars($r["SELL_OUT_BK"]),
				htmlspecialchars(''),
				htmlspecialchars($r["TAHUN"]),
				htmlspecialchars(''),
				htmlspecialchars($r["BULAN"]),
				$aksi
				
			);
			$baris++;
		}
		echo json_encode($result);

    }
	
	public function get_data_distributor()
    { 

		$id_user = $this->session->userdata("user_id");
		$id_jenis_user = $this->session->userdata("id_jenis_user");

        $s = $this->input->post('search') != null ? $this->input->post('search')["value"] : "";
		$p = $this->input->post('start') != null && $this->input->post('start') != "" && is_numeric($this->input->post('start')) ? intval($this->input->post('start')) : 0;
		$e = $this->input->post('length') != null && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
		$c = array("ID", "ID", "KD_DISTRIBUTOR", "KD_DISTRIBUTOR", "TOKO_UNIT", "TOKO_AKTIF", "SO_CLEAN_CLEAR", "VOLUME", "REVENUE", "SELL_OUT", "CREATE_BY", "CREATE_DATE", "UPDATE_BY", "UPDATE_DATE");
		$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "ASC");
		
		$hasil = $this->M_target_selling_out->get_data_distributor($s, $p, $e, $c, $o, $id_user, $id_jenis_user);
		
		$result["draw"] = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;
		$result["recordsTotal"] = intval($hasil["total"]);
		$result["recordsFiltered"] = intval($hasil["filtered"]);
		$result["data"] = array();
		
		$baris = 0;
		
		foreach($hasil["data"] as $r) {
			$tombol = array(
				"<button onclick='edit({$baris})' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></button>",
				"<button onclick='konfirmasi({$baris})' class='btn btn-danger'><i class='glyphicon glyphicon-remove'></i></button>"
			);

			$aksi = "<center>{$tombol[0]}&nbsp;{$tombol[1]}</center>";

			$result["data"][] = array(
				htmlspecialchars($baris+1),
				htmlspecialchars($r["ID"]),
				htmlspecialchars($r["KD_DISTRIBUTOR"]),
				htmlspecialchars($r["NM_DISTRIBUTOR"]. " ( ".$r["KD_DISTRIBUTOR"]." )"),
				htmlspecialchars($r["TOKO_UNIT"]),
				htmlspecialchars($r["TOKO_AKTIF"]),
				htmlspecialchars($r["SO_CLEAN_CLEAR"]),
				htmlspecialchars($r["VOLUME"]),
				htmlspecialchars($r["REVENUE"]),
				htmlspecialchars($r["SELL_OUT"]),
				htmlspecialchars(''),
				htmlspecialchars($r["TAHUN"]),
				htmlspecialchars(''),
				htmlspecialchars($r["BULAN"]),
				$aksi
			);
			$baris++;
		}

		// print_r('<pre>');
		// print_r($result);exit;

		echo json_encode($result);

    }
	
	public function refreshSO() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Sales Officer --</option>"; 
		$id_jenis_user = 1012;
		// $hasil = $this->user_model->get_user_sales($id_jenis_user);
		$data = $this->M_target_selling_out->getSO($id_jenis_user);
		foreach($data as $p) { 
			echo "<option value='{$p["ID_USER"]}'  >".htmlspecialchars($p["NAMA"]. " ( ID : ".$p["ID_USER"]." )")."</option>";
		}
	}
	
	public function refreshSalesman() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Salesman --</option>"; 
		$id_jenis_user = 1015;
		$id_user = $this->session->userdata("user_id");
		$data = $this->M_target_selling_out->getSalesman($id_jenis_user, $id_user);
		foreach($data as $p) { 
			echo "<option value='{$p["ID_USER"]}'  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".htmlspecialchars($p["NAMA"]. " ( ID : ".$p["ID_USER"]." )")."</option>";
		}
	}
	
	public function refreshTahun() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Tahun --</option>"; 

		for ($i=date('Y', strtotime('- 3 years')); $i <= date('Y', strtotime('+ 3 years')); $i++) { 
			echo "<option value='$i'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$i."</option>";
		}
	}
	
	public function refreshBulan() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Bulan --</option>"; 

		for($j=1;$j<=12;$j++){
			$dateObj   = DateTime::createFromFormat('!m', $j);
			$moon = '';
			if($j < 10){
				$moon = '0'.$j;
			} else {
				$moon = $j;
			}
			$monthName = '['.$moon.'] '.$dateObj->format('F');
			
			echo "<option value=".$moon."> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$monthName."</option>";
		}
	}
	
	public function refreshDistributor() {
         
		echo "<option value='' data-hidden='true' selected='selected'>-- Pilih Distributor --</option>"; 
		$id_jenis_user = 1012;
		$id_user = $this->session->userdata("user_id");
		$data = $this->M_target_selling_out->getDistributor($id_jenis_user, $id_user);
		foreach($data as $p) { 
			echo "<option value='{$p["KODE_DISTRIBUTOR"]}'  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".htmlspecialchars($p["NAMA_DISTRIBUTOR"]. " ( ID : ".$p["KODE_DISTRIBUTOR"]." )")."</option>";
		}
	}
	
	public function simpan() {
        $id_user = $this->session->userdata('user_id');
        $date = date('Y-m-d h:i:s');

        $volume = $this->input->post('volume');
        $revenue = $this->input->post('revenue');
        $ca = $this->input->post('ca');
        // $visit = $this->input->post('visit');
        $noo = $this->input->post('noo');
        $market_share = $this->input->post('market_share');
        $so = $this->input->post('so');
		
		
		$column = array(
			'VOLUME',
			'REVENUE',
			'CA',
			// 'VISIT',
			'NOO',
			'MARKET_SHARE',
			'CREATE_BY',
			'CREATE_DATE',
			'UPDATE_BY',
			'UPDATE_DATE',
			'AM'
		);
		
		$data = array(
			"'{$volume}'",
			"'{$revenue}'",
			"'{$ca}'",
			// "'{$visit}'",
			"'{$noo}'",
			"'{$market_share}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'",
			"'{$so}'"
		);
		
		$cek_ada = $this->M_target_selling_out->cek_ada($so);
		
		if($cek_ada == 0) {
			$q = $this->M_target_selling_out->simpan($column, $data); 
			if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
			echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
		}
	}
	
    public function simpan_salesman() {
        $id_user = $this->session->userdata('user_id');
        $date = date('Y-m-d h:i:s');

        $sales = $this->input->post('sales');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');

        // print_r($bulan);exit;
        $tu = $this->input->post('tu');
        // $visit = $this->input->post('visit');
        $ta = $this->input->post('ta');
        $tb = $this->input->post('tb');
        $sell_sdg = $this->input->post('vso');
        $sell_bk = $this->input->post('vso_bk');
		$column = array(
			'ID_SALES',
			'TAHUN',
			'BULAN',
			'TOKO_UNIT',
			// 'VISIT',
			'TOKO_AKTIF',
			'TOKO_BARU',
			'SELL_OUT_SDG',
			'SELL_OUT_BK',
			'CREATE_BY',
			'CREATE_DATE',
			'UPDATE_BY',
			'UPDATE_DATE'
		);
		
		$data = array(
			"'{$sales}'",
			"'{$tahun}'",
			"'{$bulan}'",
			"'{$tu}'",
			// "'{$visit}'",
			"'{$ta}'",
			"'{$tb}'",
			"'{$sell_sdg}'",
			"'{$sell_bk}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'"
		);
		
		$cek_ada = $this->M_target_selling_out->cek_ada_salesman($sales, $id_user, $tahun ,$bulan);
		
		if($cek_ada == 0) {
			$q = $this->M_target_selling_out->simpan_salesman($column, $data); 
			if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
			echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
		}
	}
    
    public function simpan_distributor() {
        $id_user = $this->session->userdata('user_id');
        $date = date('Y-m-d h:i:s');

        $dist = $this->input->post('dist');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');

        $tu = $this->input->post('tu');
        $ta = $this->input->post('ta');
        $so_cc = $this->input->post('so_cc');
        $volume = $this->input->post('volume');
        $revenue = $this->input->post('revenue');
        $sell_out = $this->input->post('vso_bk');
		
		$column = array(
			'KD_DISTRIBUTOR',
			'TAHUN',
			'BULAN',
			'TOKO_UNIT',
			'TOKO_AKTIF',
			'SO_CLEAN_CLEAR',
			'VOLUME',
			'REVENUE',
			'SELL_OUT',
			'CREATE_BY',
			'CREATE_DATE',
			'UPDATE_BY',
			'UPDATE_DATE'
		);
		
		$data = array(
			"'{$dist}'",
			"'{$tahun}'",
			"'{$bulan}'",
			"'{$tu}'",
			"'{$ta}'",
			"'{$so_cc}'",
			"'{$volume}'",
			"'{$revenue}'",
			"'{$sell_out}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'",
			"'{$id_user}'",
			"TIMESTAMP'{$date}'"
		);
		
		$cek_ada = $this->M_target_selling_out->cek_ada_distributor($dist, $id_user, $tahun ,$bulan);
		
		if($cek_ada == 0) {
			$q = $this->M_target_selling_out->simpan_distributor($column, $data); 
			if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
			echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
		}
	}
    
    
	public function update() {
		// if(isset($this->input->post('id'))) {  
		if($this->input->post('id') != null) {
			$id_user = $this->session->userdata('user_id');
			$date = date('Y-m-d h:i:s');			
			
			$id = $this->input->post('id');
			$volume = $this->input->post('volume');
			$revenue = $this->input->post('revenue');
			$ca = $this->input->post('ca');
			// $visit = $this->input->post('visit');
			$noo = $this->input->post('noo');
			$market_share = $this->input->post('market_share');
			$so = $this->input->post('so');
			
			$column = array(
				'VOLUME',
				'REVENUE',
				'CA',
				// 'VISIT',
				'NOO',
				'MARKET_SHARE',
				'UPDATE_BY',
				'UPDATE_DATE',
				'AM'
			);
			
			$data = array(
				"'{$volume}'",
				"'{$revenue}'",
				"'{$ca}'",
				// "'{$visit}'",
				"'{$noo}'",
				"'{$market_share}'",
				"'{$id_user}'",
				"TIMESTAMP'{$date}'",
				"'{$so}'",
			);
			
			$jml_kolom = count($column);
			$data_baru = array();
			
			for($i = 0; $i < $jml_kolom; $i++) {
				$data_baru[] = $column[$i]."=".$data[$i];
			}
			
			$cek_ada = $this->M_target_selling_out->cek_ada($so, $id);
			
			if($cek_ada == 0) {
				$q = $this->M_target_selling_out->update($id, $data_baru);
				if($q) {
					echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
				} else {
					echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
				}
			} else {
				echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	} 
    
	public function update_salesman() {
		// if(isset($this->input->post('id'))) {  
		if($this->input->post('id') != null) {
			$id_user = $this->session->userdata('user_id');
			$date = date('Y-m-d h:i:s');			
			
			$id = $this->input->post('id');
			$thn = $this->input->post('thn');
			$bln = $this->input->post('bln');

			$sales = $this->input->post('sales');
			$tahun = $this->input->post('tahun');
			$bulan = $this->input->post('bulan');
			$tu = $this->input->post('tu');
			// $visit = $this->input->post('visit');
			$ta = $this->input->post('ta');
			$tb = $this->input->post('tb');
			$sell_sdg = $this->input->post('vso');
			$sell_bk = $this->input->post('vso_bk');
			$column = array(
				'ID_SALES',
				'TAHUN',
				'BULAN',
				'TOKO_UNIT',
				// 'VISIT',
				'TOKO_AKTIF',
				'TOKO_BARU',
				'SELL_OUT_SDG',
				'SELL_OUT_BK',
				'CREATE_BY',
				'CREATE_DATE',
				'UPDATE_BY',
				'UPDATE_DATE'
			);
			
			$data = array(
				"'{$sales}'",
				"'{$tahun}'",
				"'{$bulan}'",
				"'{$tu}'",
				// "'{$visit}'",
				"'{$ta}'",
				"'{$tb}'",
				"'{$sell_sdg}'",
				"'{$sell_bk}'",
				"'{$id_user}'",
				"TIMESTAMP'{$date}'",
				"'{$id_user}'",
				"TIMESTAMP'{$date}'",
			);
			
			$jml_kolom = count($column);
			$data_baru = array();
			
			for($i = 0; $i < $jml_kolom; $i++) {
				$data_baru[] = $column[$i]."=".$data[$i];
			}
			
			$cek_ada = $this->M_target_selling_out->cek_ada_salesman($sales, $id_user, $tahun ,$bulan);

			// print_r($sales);exit;
			
			if($cek_ada == 0) {
				$q = $this->M_target_selling_out->update_salesman($data_baru, $id_user, $id, $thn, $bln);
				if($q) {
					echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
				} else {
					echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
				}
			} else {
				echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
			}
			
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	} 
	
	public function update_distributor() {
		// if(isset($this->input->post('id'))) {  
		if($this->input->post('id') != null) {
			$id_user = $this->session->userdata('user_id');
			$date = date('Y-m-d h:i:s');			
			
			$id = $this->input->post('id');
			$thn = $this->input->post('thn');
			$bln = $this->input->post('bln');

			$tahun = $this->input->post('tahun');
			$bulan = $this->input->post('bulan');
			$dist = $this->input->post('dist');
			$tu = $this->input->post('tu');
			$ta = $this->input->post('ta');
			$so_cc = $this->input->post('so_cc');
			$volume = $this->input->post('volume');
			$revenue = $this->input->post('revenue');
			$sell_out = $this->input->post('vso_bk');
			
			$column = array(
				'KD_DISTRIBUTOR',
				'TAHUN',
				'BULAN',
				'TOKO_UNIT',
				'TOKO_AKTIF',
				'SO_CLEAN_CLEAR',
				'VOLUME',
				'REVENUE',
				'SELL_OUT',
				'CREATE_BY',
				'CREATE_DATE',
				'UPDATE_BY',
				'UPDATE_DATE'
			);
			
			$data = array(
				"'{$dist}'",
				"'{$tahun}'",
				"'{$bulan}'",
				"'{$tu}'",
				"'{$ta}'",
				"'{$so_cc}'",
				"'{$volume}'",
				"'{$revenue}'",
				"'{$sell_out}'",
				"'{$id_user}'",
				"TIMESTAMP'{$date}'",
				"'{$id_user}'",
				"TIMESTAMP'{$date}'",
			);
			
			$jml_kolom = count($column);
			$data_baru = array();
			
			for($i = 0; $i < $jml_kolom; $i++) {
				$data_baru[] = $column[$i]."=".$data[$i];
			}
			
			$cek_ada = $this->M_target_selling_out->cek_ada_distributor($dist, $id_user, $tahun, $bulan);
			
			if($cek_ada == 0) {
				$q = $this->M_target_selling_out->update_distributor($data_baru, $id_user, $id, $thn, $bln);
				if($q) {
					echo json_encode(array('notif' => '1', 'message' => 'Berhasil menyimpan data.'));
				} else {
					echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
				}
			} else {
				echo json_encode(array('notif' => '3', 'message' => 'Gagal menyimpan data. Sales Officer yang anda pilih sudah memiliki target.'));
			}
			
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	} 
    
	public function hapus() {
		// if(isset($this->input->post('id'))) {
		if($this->input->post('id') != null) {  
			$id = $this->input->post('id');
			$q = $this->M_target_selling_out->hapus($id);
			
           if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menghapus data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
	
	public function hapus_salesman() {
		// if(isset($this->input->post('id'))) {
		if($this->input->post('id') != null) {  

			$id_user = $this->session->userdata("user_id");
			$id = $this->input->post('id');
			$q = $this->M_target_selling_out->hapus_salesman($id, $id_user);
			
           if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menghapus data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}
	
	public function hapus_distributor() {
		// if(isset($this->input->post('id'))) {
		if($this->input->post('id') != null) {  
			$id_user = $this->session->userdata("user_id");

			$id = $this->input->post('id');
			$q = $this->M_target_selling_out->hapus_distributor($id, $id_user);
			
           if($q) {
				echo json_encode(array('notif' => '1', 'message' => 'Berhasil menghapus data.'));
			} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.'));
			}
		} else {
				echo json_encode(array('notif' => '2', 'message' => 'Gagal menyimpan data.')); 
		}
	}

}