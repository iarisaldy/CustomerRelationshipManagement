<?php

class M_Penjualan Extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	 
	public function get_data()
	{ 
		$q = $this->db->query("SELECT
				A.ID_KUNJUNGAN_CUSTOMER,
				A.ID_TOKO,
				C.NAMA_TOKO,
				TGL_RENCANA_KUNJUNGAN,
				B.ID_PRODUK,
				HARGA_PEMBELIAN,
				HARGA_PENJUALAN,
				C.ID_DISTRIK,
				F.NAMA_DISTRIK, 
				C.ID_PROVINSI, 
				E.NAMA_PROVINSI
			FROM
				CRMNEW_KUNJUNGAN_CUSTOMER A
				JOIN CRMNEW_HASIL_SURVEY B ON A.ID_KUNJUNGAN_CUSTOMER = B.ID_KUNJUNGAN_CUSTOMER
				JOIN CRMNEW_CUSTOMER C ON A.ID_TOKO = C.ID_CUSTOMER 
				--JOIN CRMNEW_PRODUK_SURVEY D ON B.ID_PRODUK = D.ID_PRODUK
				JOIN CRMNEW_M_PROVINSI E ON C.ID_PROVINSI = E.ID_PROVINSI
				JOIN CRMNEW_M_DISTRIK F ON C.ID_DISTRIK = F.ID_DISTRIK
			WHERE
				TO_CHAR( A.TGL_RENCANA_KUNJUNGAN, 'YYYY-MM-DD' ) = '2020-01-02' 
				AND A.DELETED_MARK = 0 
				AND B.DELETE_MARK = 0 
				AND ( HARGA_PEMBELIAN IS NOT NULL AND HARGA_PEMBELIAN != 0 ) 
				AND ( HARGA_PENJUALAN IS NOT NULL AND HARGA_PENJUALAN != 0 )
		"); 
				
		return $q ? $q->result_array() : array();
	}  
	public function penjualan_by_area(){
            
        $sql = "
            select
                sebaran_prov.id_provinsi,
                sebaran_prov.nama_provinsi,
                nvl(jml_toko.jml, 0) as populasi_toko,
                sebaran_prov.new_region
            from
                (select id_provinsi, nama_provinsi, new_region 
                    from crmnew_m_provinsi
                    where new_region is not null
                    order by new_region, urutan_prov
                ) sebaran_prov
            left join
                ( select ID_PROVINSI, nama_provinsi, count(id_customer) as jml 
                    from view_data_toko_customer
                    group by ID_PROVINSI, nama_provinsi
                ) jml_toko 
                on jml_toko.id_provinsi = sebaran_prov.id_provinsi
        ";
        
        return $this->db->query($sql)->result();
	}
	
	

	
	

 
}
