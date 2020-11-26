<?php
	if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
 
	class Model_ResumeCanvassing extends CI_Model {

		public function __construct(){
			parent::__construct();
			$this->load->database();	
		}

		public function resumeSurvey($idDistributor = null, $idProvinsi = null, $idKota = null, $merk = null){
			if(isset($idDistributor)){
				if($idDistributor != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_DISTRIBUTOR", $idDistributor);
				}
			}

			if(isset($idProvinsi)){
				if($idProvinsi != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_PROVINSI", $idProvinsi);
				}
			}

			if(isset($idKota)){
				if($idKota != ""){
					$this->db->where("CRMNEW_CUSTOMER.ID_DISTRIK", $idKota);
				}
			}

			if(isset($merk)){
				if($merk != ""){
					$this->db->where("CRMNEW_JENIS_PRODUK_GROUP.GROUP_ID", $merk);
				}
			}


			$this->db->select("CRMNEW_CUSTOMER.NAMA_TOKO, CRMNEW_PRODUK_SURVEY.NAMA_PRODUK, TO_CHAR(CRMNEW_HASIL_SURVEY.CREATE_DATE, 'YYYY-MM-DD') AS TGL_KUNJUNGAN, CRMNEW_HASIL_SURVEY.STOK_SAAT_INI, CRMNEW_HASIL_SURVEY.HARGA_PENJUALAN, CRMNEW_HASIL_SURVEY.HARGA_PEMBELIAN, CRMNEW_HASIL_SURVEY.VOLUME_PENJUALAN, CRMNEW_HASIL_SURVEY.VOLUME_PEMBELIAN")->from("CRMNEW_HASIL_SURVEY")->join("CRMNEW_CUSTOMER", "CRMNEW_HASIL_SURVEY.ID_TOKO = CRMNEW_CUSTOMER.ID_CUSTOMER")->join("CRMNEW_PRODUK_SURVEY", "CRMNEW_HASIL_SURVEY.ID_PRODUK = CRMNEW_PRODUK_SURVEY.ID_PRODUK")->join("CRMNEW_JENIS_PRODUK_GROUP", "CRMNEW_PRODUK_SURVEY.GROUP_ID = CRMNEW_JENIS_PRODUK_GROUP.GROUP_ID")->where("CRMNEW_HASIL_SURVEY.STOK_SAAT_INI IS NOT NULL")->where("CRMNEW_HASIL_SURVEY.DELETE_MARK", "0");
			$data = $this->db->get();
			return $data->result();
		}

		public function resumePromotion($idDistributor = null, $idProvinsi = null, $idKota = null, $merkProduk = null){
			$whereDistributor = "CC.ID_DISTRIBUTOR IS NOT NULL";
			if(isset($idDistributor)){
				if($idDistributor != ""){
					$whereDistributor = "CC.ID_DISTRIBUTOR = '$idDistributor'";
				}
			}

			$whereProvinsi = "";
			if(isset($idProvinsi)){
				if($idProvinsi != ""){
					$whereProvinsi = "AND CC.ID_PROVINSI = '$idProvinsi'";
				}
			}

			$whereKota = "";
			if(isset($idKota)){
				if($idKota != ""){
					$whereKota = "AND CC.ID_DISTRIK = '$idKota'";
				}
			}

			$whereProduk = "";
			if(isset($merkProduk)){
				if($merkProduk != ""){
					$whereProduk = "AND JPG.GROUP_ID = '$merkProduk'";
				}
			}

			$sql = "SELECT DISTINCT
						JPG.GROUP_ID,
						JPG.JENIS_PRODUK,
						JPG.SMI_GROUP,
						HSP.POTONGAN_HARGA,
						HSP.BONUS_SEMEN,
						HSP.POINT_REWARD,
						HSP.VOUCER,
						HSP.BONUS_WISATA 
					FROM
						CRMNEW_JENIS_PRODUK_GROUP JPG
						JOIN CRMNEW_PRODUK_SURVEY PS ON JPG.GROUP_ID = PS.GROUP_ID
						JOIN (
					SELECT
						HASIL_SURVEY_PROMOSI.ID_PRODUK,
						HASIL_SURVEY_PROMOSI.ID_TOKO,
						HASIL_SURVEY_PROMOSI.NAMA_PRODUK,
						HASIL_SURVEY_PROMOSI.POTONGAN_HARGA,
						HASIL_SURVEY_PROMOSI.BONUS_SEMEN,
						HASIL_SURVEY_PROMOSI.POINT_REWARD,
						HASIL_SURVEY_PROMOSI.VOUCER,
						HASIL_SURVEY_PROMOSI.BONUS_WISATA 
					FROM
						HASIL_SURVEY_PROMOSI 
					WHERE
						HASIL_SURVEY_PROMOSI.DELETE_MARK_PROMOSI = '0' 
						AND COALESCE( HASIL_SURVEY_PROMOSI.POTONGAN_HARGA, HASIL_SURVEY_PROMOSI.BONUS_SEMEN, HASIL_SURVEY_PROMOSI.POINT_REWARD, HASIL_SURVEY_PROMOSI.VOUCER, HASIL_SURVEY_PROMOSI.BONUS_WISATA ) IS NOT NULL
						) HSP ON PS.ID_PRODUK = HSP.ID_PRODUK
						JOIN CRMNEW_CUSTOMER CC ON HSP.ID_TOKO = CC.ID_CUSTOMER
					WHERE
						$whereDistributor $whereProvinsi $whereKota $whereProduk
					ORDER BY
						JPG.SMI_GROUP DESC";
            $promosi = $this->db->query($sql);
            // echo $this->db->last_query();
            if($promosi->num_rows() > 0){
                return $promosi->result();
            } else {
                return false;
            }
        }

	}
?>