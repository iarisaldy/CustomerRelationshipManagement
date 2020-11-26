<?php
    if (!defined('BASEPATH')) { exit('NO DIRECT SCRIPT ACCESS ALLOWED');}

    class Toko_tidak_dikunjungi_model extends CI_Model {
		
		public function listToko(){
			$id_kunjungan = null;
            if(isset($_POST['id_kunjungan'])){
                $id_kunjungan = $_POST['id_kunjungan'];
            }
            
            $sql = "
                SELECT 
					TTD.ID_TOKO_TIDAK_DIKUNJUNGI,
                    TTD.ID_KUNJUNGAN,
					TTD.NO_MR_DETAIL,
					MRD.NAMA_DETAIL,
					TTD.DESCRIPTION
                FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
					JOIN CRMNEW_MR_DETAIL MRD ON MRD.NO_DETAIL = TTD.NO_MR_DETAIL
                WHERE TTD.delete_mark = 0
            ";
            
            if($id_kunjungan != null){
                $sql .= " AND TTD.ID_KUNJUNGAN IN ($id_kunjungan)";
            }
            
            $list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return false;
            }
		}
		
		public function getToko($id_user){
			$setTGL = date("Y-").sprintf("%02d",date("m")-1) . '-01';
			
			// print_r($setTGL); 
			// exit;  
			
			$sql = "
				SELECT
					TTD.ID_TOKO_TIDAK_DIKUNJUNGI,
					TTD.ID_KUNJUNGAN,
					--KHS.NAMA_TOKO,
					--TO_CHAR(KHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') AS TGL_RENCANA_KUNJUNGAN,
					TTD.NO_MR_DETAIL,
					CMD.NAMA_DETAIL,
					TTD.DESCRIPTION AS DESKRIPSI
				FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
					JOIN V_KUNJUNGAN_HARIAN_SALES KHS
						ON ttd.id_kunjungan = khs.id_kunjungan_customer
					JOIN CRMNEW_MR_DETAIL CMD
						ON ttd.no_mr_detail = cmd.no_detail
				WHERE khs.id_user = '$id_user' 
					AND TO_CHAR(KHS.TGL_RENCANA_KUNJUNGAN,'YYYY-MM-DD') >= '$setTGL'
			";
			
			$list_data = $this->db->query($sql);
            if($list_data->num_rows() > 0){
                return $list_data->result();
            } else {
                return $list_data->result();//null;
            }
		}
		
		public function Simpan_alasan_tokoTidakDikunjungi($id_user, $reason){	//save model
			
			$data =array();
			foreach($reason as $p){ 
				
				$hasil = array(
					'ID_KUNJUNGAN'				=> $p['ID_KUNJUNGAN'],
					'NO_MR_DETAIL'				=> $p['NO_MR_DETAIL'],
					'DESCRIPTION'				=> $p['DESKRIPSI'],
					'CREATE_BY'					=> $id_user,
					'CREATE_DATE'				=> date('d-M-y h.s.i A'),
					'DELETE_MARK'				=> 0
				);
				
				array_push($data, $hasil);

			}
			
			$hasil = $this->db->insert_batch('CRMNEW_TOKO_TIDAK_DIKUNJUNGI',$data);
			
			if($hasil){
				$baris = count($data);
				
				$sql = "
					SELECT
					*
					FROM 
						(
							SELECT 
							TTD.ID_TOKO_TIDAK_DIKUNJUNGI,
							TTD.ID_KUNJUNGAN,
							TTD.NO_MR_DETAIL,
							MRD.NAMA_DETAIL,
							TTD.DESCRIPTION
							FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
								JOIN CRMNEW_MR_DETAIL MRD ON MRD.NO_DETAIL = TTD.NO_MR_DETAIL
                            WHERE TTD.DELETE_MARK = 0
							ORDER BY TTD.ID_TOKO_TIDAK_DIKUNJUNGI DESC   
						)
					WHERE ROWNUM <='$baris'
				";
				
				return $this->db->query($sql)->result_array();
			}
			else {
				return null;
			}
			
		}
		
		public function delTokoTdkDikunjungi($id_kunjungan, $id_mr){
			$sqlup = "
					DELETE (SELECT *
							FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
							INNER JOIN CRMNEW_MR_DETAIL MRD
								ON MRD.NO_DETAIL = TTD.NO_MR_DETAIL
							WHERE TTD.ID_KUNJUNGAN IN ($id_kunjungan) AND MRD.ID_MR = $id_mr)
					COMMIT
				";
					
			$this->db->query($sqlup); 
			return $this->db->affected_rows();
		}
		
		public function delTokoTdkDikunjungiBynoMr($id_kunjungan, $no_mr_detail){
			$sqlup = "
					DELETE (SELECT *
							FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
							WHERE TTD.ID_KUNJUNGAN = '$id_kunjungan' AND TTD.NO_MR_DETAIL IN ($no_mr_detail))
					COMMIT
				";
					
			$this->db->query($sqlup);
			return $this->db->affected_rows();
		}
		
		public function delTokoTdkDikunjungiByidKunjungan($id_ttd){
			$sqlup = "
					DELETE (SELECT *
							FROM CRMNEW_TOKO_TIDAK_DIKUNJUNGI TTD
							WHERE TTD.id_toko_tidak_dikunjungi IN ($id_ttd))
					COMMIT
				";
					
			$this->db->query($sqlup);
			return $this->db->affected_rows();
		}
		
	}

?>