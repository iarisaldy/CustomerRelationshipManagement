<?php

class fungsibi {
	
	function getRealisasiKumSI($connm,$org,$datekemarin){
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$zakcode='121-301';
		$curcode='121-302';	
		$queryTot= "	
		select tb3.*,tb4.nm_region from(
		select prov,nm_prov_1,id_region,budat,item_no,sum(target_real) as realto from (
		select tb1.*,tb2.id_region,tb2.nm_prov_1 from (
		select propinsi_to as prov,to_char(tgl_cmplt,'yyyymmdd')as budat, sum(kwantumx) as target_real, substr(item_no,0,7) as item_no
		from zreport_rpt_real 
		where         
		to_char(tgl_cmplt,'YYYYMMDD') between '".$thn.$bln."01' and '$datekemarin'
		and ( (order_type <>'ZNL' and
		(item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
		and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') 
		and com in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin)  and no_polisi <> 'S11LO'
		and sold_to like '0000000%' 
		AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')group by prov)
		group by propinsi_to,to_char(tgl_cmplt,'yyyymmdd') ,substr(item_no,0,7)
		order by PROV,budat
		)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)
		)
		group by prov,nm_prov_1,id_region,budat,item_no
		)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
		order by tb3.prov,tb3.id_region,budat,item_no
		
		";
		$queryTot= oci_parse($connm, $queryTot);
		$sukses_query = oci_execute($queryTot);
		while ($dataTot = oci_fetch_array($queryTot)) {
			$dataall['REKAP_REGION'][$dataTot['BUDAT']][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_REALTGLPROV'][$dataTot['BUDAT']][$dataTot['PROV']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_PROV'][$dataTot['PROV']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_TOTREGION'][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			if($dataTot['ITEM_NO']==$zakcode){
				$dataall['REKAP_BUDATZAK'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}else{
				$dataall['REKAP_BUDATTO'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}
			$dataall['M_REGION'][$dataTot['ID_REGION']]=$dataTot['NM_REGION'];
			$dataall['M_PROV'][$dataTot['PROV']]=$dataTot['NM_PROV_1'];
		}
		
		return $dataall;
	}
    
	function getTargetRealisasisg($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		if($orgv_st=='7'){
			$sqlm="
			--alias 7000
			union
			select 7000 as CO,BULAN as BLN,TAHUN as THN,concat(10,substr(KD_KOTA,0,2)) as PROV,ITEM_NO as TIPE,SUM(TARGET) as quantum 
			from ZREPORT_TARGET_PLANT where 
			BULAN='$bln' and TAHUN='$thn' and BRAN12 is null and KODE_DA is null and ITEM_NO='121-301'
			and KD_PLANT like '5%'
			group by BULAN,TAHUN,concat(10,substr(KD_KOTA,0,2)),ITEM_NO
			";
		};
		$sqltarget="
		select tb3.*,tb4.nm_region from(
		select prov,id_region,budat,item_no,sum(target_real) as target_realto from (
		select tb1.*,tb2.id_region from (
		
			 select a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_real ,d.tipe as item_no
			 from (
				select $com as CO,BULAN as BLN,TAHUN as THN,concat(10,substr(KD_KOTA,0,2)) as PROV,ITEM_NO as TIPE,SUM(TARGET) as quantum 
				from ZREPORT_TARGET_PLANT where 
				BULAN='$bln' and TAHUN='$thn' and BRAN12 is null and KODE_DA is null and ITEM_NO='121-301'
				and KD_PLANT like '$orgv_st%'
				group by BULAN,TAHUN,concat(10,substr(KD_KOTA,0,2)),ITEM_NO
				$sqlm
				union
				select $com as co,bln,thn,prov,tipe,quantum from sap_t_rencana_sales_type_adj 
				where tipe='121-302' and co in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) and thn='$thn' and prov!='1092' and prov!='0001'
				and bln='$bln'
			 ) a left join zreport_m_provinsi b on a.prov = b.kd_prov 
			 left join zreport_porsi_sales_region c on c.region=5 and c.vkorg= a.co 
			 and c.budat like '$thn$bln%' and c.tipe = a.tipe left join (
			 select region, tipe, sum(porsi) as total_porsi 
			 from zreport_porsi_sales_region 
				 where budat like '$thn$bln%' and vkorg ='$com' group by region, tipe 
			 )d on c.region = d.region 
			 and d.tipe = a.tipe where co ='$com' and thn = '$thn' and bln = '$bln' 
			 group by co, thn, bln, a.prov, c.budat ,d.tipe 
			 
		)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)
		)
		group by prov,id_region,budat,item_no
		)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
		order by tb3.prov,tb3.id_region,budat,item_no	 
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_TARGET'][$rowt[BUDAT].$rowt[ID_REGION].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TARGETPROPBUD'][$rowt[BUDAT].$rowt[PROV].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TOTTARGET'][$rowt[ID_REGION].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TOTTARGETPROP'][$rowt[PROV].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
		}
		return $dataall;
	}
	
	function getLaporanPlant($connm,$com,$dayKemarin){
		unset($dataall);
		$datenowf=date("Ymd");
		$formdatmkll=date("Ymd", strtotime("$datenowf -31 days"));
		$todatmkll=date("Ymd", strtotime("$datenowf +31 days"));
		$plantinvo="select plant
		from zreport_rpt_real 
		where         
		to_char(TGL_SPJ,'yyyymmdd') between '$formdatmkll' and '$todatmkll'
		and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
		and (plant not like '73%'  and plant not like '53%' and plant<>'5490')
		and plant is not null
		group by plant";
		//$plantinvo="'7403','7601','7401','7408','7409','7405','7608','7611','7407','7614','7609','7410','7412','7415','7416','7615','7807','7806','7809','7810','5401'";
		$sqlplant="
		select tno11.*,tno12.JMLSIAP50_CURAH from (
		select tno9.*,tno10.JMLSIAP50_ZAK from (
		select tno7.*,tno8.JMLSIAP40_CURAH from (
		select tno5.*,tno6.JMLSIAP40_ZAK from (
		select tno3.*,tno4.JML_CURAH from (
		select tno1.*,tno2.JML_ZAK from (

		select tb5.*, tb6.stok from (
		select tb3.*,tb4.realcur from (
		select tb1.*,tb2.realzak from
		(
			select KD_PLANT,NAME,KAPASITAS_BAG,KAPASITAS_CURAH  from ZREPORT_M_PLANT where ORG in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			AND	KD_PLANT IN($plantinvo)
		)tb1 left join(
			select PLANT,sum(kwantumx) as realzak from zreport_rpt_real where
			TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			and order_type <>'ZNL' 
			and item_no like '121-301%' 
			and item_no <> '121-301-0240'
			and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and no_polisi <> 'S11LO'
			and sold_to like '0000000%'
			group by PLANT

		)tb2 on(KD_PLANT=PLANT)
		)tb3 left join(
			 select PLANT as PLANTC,sum(kwantumx) as realcur from zreport_rpt_real where
			 TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			 and item_no like '121-302%' 
			 and order_type <>'ZNL'
			 and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
			 and no_polisi <> 'S11LO'
			 and sold_to like '0000000%'
			 group by PLANT                        
		)tb4 on(KD_PLANT=PLANTC)
		)tb5 left join(
			select nmplan, sum (qty_entry) as stok
			from zreport_stock_silo
			where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and create_date = to_date('$dayKemarin','YYYYMMDD')
			group by nmplan
			union
			select WERKS as PLANT,SUM(TOTAL) as stok from ROMA_SILO_DAY2DAYX
			where to_char(create_date,'YYYYMMDD')='$dayKemarin'
			group by WERKS

		)tb6 on(tb5.KD_PLANT=tb6.NMPLAN)

		)tno1 left join (
			select PLANT, SUM(1) as JML_ZAK 
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS between 10 and 30 
			and TIPE_TRUK not in ('308','107','309','608')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)   
			)      
			group by PLANT 
		)tno2 on (tno1.KD_PLANT=tno2.PLANT)
		)tno3 left join (
			select PLANT, SUM(1) as JML_CURAH
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS between 10 and 30 
			and TIPE_TRUK in ('308')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)    
			)      
			group by PLANT 
		)tno4 on (tno3.KD_PLANT=tno4.PLANT)
		)tno5 left join (
			select PLANT, SUM(1) as JMLSIAP40_ZAK
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS=40
			and TIPE_TRUK not in ('308','107','309','608')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)    
			)      
			group by PLANT 
		)tno6 on (tno5.KD_PLANT=tno6.PLANT)
		)tno7 left join (
			select PLANT, SUM(1) as JMLSIAP40_CURAH
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS=40 
			and TIPE_TRUK in ('308','608')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)    
			)      
			group by PLANT 
		)tno8 on (tno7.KD_PLANT=tno8.PLANT)
		)tno9 left join (
			select PLANT, SUM(1) as JMLSIAP50_ZAK
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS between 50 and 55
			and TIPE_TRUK not in ('308','107','309','608')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)    
			)      
			group by PLANT 
		)tno10 on (tno9.KD_PLANT=tno10.PLANT)
		)tno11 left join (
			select PLANT, SUM(1) as JMLSIAP50_CURAH
			from (
			select PLANT,NO_POLISI,TIPE_TRUK
			from ZREPORT_RPT_REAL_NON70  where COM in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and STATUS  between 50 and 55
			and TIPE_TRUK in ('308','608')
			and no_transaksi NOT IN (SELECT g.no_transaksi FROM zreport_rpt_real g)    
			)      
			group by PLANT 
		)tno12 on (tno11.KD_PLANT=tno12.PLANT)
		order by KD_PLANT asc
		";    
		$queryplant= oci_parse($connm, $sqlplant);
		oci_execute($queryplant);		
		while($row=oci_fetch_array($queryplant)){            
				$dataall['DATA_PLANT'][$row[KD_PLANT]]=$row;
				$dataall['M_PLANT'][$row[KD_PLANT]]=$row[NAME];
		}   
		return $dataall;
	}
	
	function getTargetPlant($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		if($orgv_st=='7'){
			$sqlm = " or KD_PLANT like '5%' ";
		}
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqltargetPlant="
			select tb1.*,(tb1.TARGET*tb2.PORSIV) as TARGETH  from (
			select KD_PLANT,ITEM_NO,SUM(TARGET) as TARGET from ZREPORT_TARGET_PLANT where 
			BULAN='$bln' and TAHUN='$thn' and BRAN12 is null and KODE_DA is null
			and (KD_PLANT like '$orgv_st%'$sqlm )
			group by KD_PLANT,ITEM_NO
			)tb1 left join (    
				select c.TIPE, SUM(PORSI/total_porsi) as PORSIV from (
					select region,TIPE,PORSI from zreport_porsi_sales_region
					where vkorg = '$com' and region=5
					and BUDAT='$dayKemarin'
				)c left join(
					select region, tipe, sum(porsi) as total_porsi 
					from zreport_porsi_sales_region 
					where budat like '$thn$bln%' and vkorg ='$com' group by region, tipe 
				)d on(c.TIPE=d.TIPE and c.REGION=d.REGION)
				group by c.TIPE
			)tb2 on (tb1.ITEM_NO=tb2.TIPE)
			order by KD_PLANT,ITEM_NO
		";    
		$querytargetP= oci_parse($connm, $sqltargetPlant);
		oci_execute($querytargetP);		
		while($rowp=oci_fetch_array($querytargetP)){            
			 $dataall['DATA_TARGETPLANT'][$rowp[KD_PLANT].$rowp[ITEM_NO]] =$rowp[TARGETH];		
		}  
		
		//PERSER TARGET CURAH
		$sqlTCURAH="
		select tb1.*,tb2.Name as NM_PLANT from(
			select * from ZREPORT_T_CURAH where DELETE_MARK=0 and ORG in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
		)tb1 left join ZREPORT_M_PLANT tb2 on(tb1.plant=tb2.kd_plant)
		";    
		$queryTCurah= oci_parse($connm, $sqlTCURAH);
		oci_execute($queryTCurah);		
		while($rowtcur=oci_fetch_array($queryTCurah)){            
				$dataall['DATA_PERSNCURAHPLANT'][$rowtcur[PLANT]] = $rowtcur[PERSEN];
				$dataall['DATA_MCURAHPLANT'][$rowtcur[PLANT]] = $rowtcur[NM_PLANT];
		} 
		return $dataall;
	}
	
	function getResume($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqlresum="
			select tb1.*,tb2.NM_PROV,tb2.URUT_BARU from(
			select * from ZREPORT_RPTREAL_RESUM
			where tahun='$thn' and bulan='$bln' and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
			)tb1 left join(
			select KD_PROV,NM_PROV,URUT_BARU from (
			select KD_PROV,NM_PROV,URUT_BARU from ZREPORT_M_PROVINSI
			where KD_PROV<>'0001'
			union
			select '9999' as KD_PROV,'Domestik' as NM_PROV,9998 as URUT_BARU from dual
			union
			select '0001' as KD_PROV,'Ekspor' as NM_PROV,9999 as URUT_BARU from dual
			)
			order by URUT_BARU ASC
			)tb2 on(tb1.propinsi=tb2.kd_prov)
			order by com,bulan,tahun,URUT_BARU,tipe ASC
		";
		$vsqlresum= oci_parse($connm, $sqlresum);
		oci_execute($vsqlresum);
		while($rowtnmr=oci_fetch_array($vsqlresum)){            
				$dataall['DATA_REKAPRESUM'][] = $rowtnmr;
				$dataall['DATA_REKAPREAL'][$rowtnmr['TIPE']][$rowtnmr['PROPINSI']]['REALTO'] += $rowtnmr['REALTO'];
				$dataall['DATA_REKAPREAL_ALL'][$rowtnmr['PROPINSI']]['REALTO'] += $rowtnmr['REALTO'];
				$dataall['DATA_REKAPREAL'][$rowtnmr['TIPE']][$rowtnmr['PROPINSI']]['TARGET_RKAP'] += $rowtnmr['TARGET_RKAP'];
				$dataall['DATA_REKAPREAL_ALL'][$rowtnmr['PROPINSI']]['TARGET_RKAP'] += $rowtnmr['TARGET_RKAP'];
				$dataall['DATA_MPROV'][$rowtnmr['PROPINSI']]= $rowtnmr['NM_PROV'];
		}
		return $dataall;
	}
	
	function getRealBagPlantProv($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqlrealbagPlant="
			select tb3.*,tb4.nm_region from(
			select tb1.*,tb2.id_region,tb2.nm_prov from (
			select tb1.*,tb2.prov,tb2.realzak from
			(
				select KD_PLANT,NAME,KAPASITAS_BAG,KAPASITAS_CURAH  from ZREPORT_M_PLANT where ORG in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
			)tb1 left join(
				select PLANT,Propinsi_to as prov,sum(kwantumx) as realzak from zreport_rpt_real where
				TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
				and order_type <>'ZNL' 
				and item_no like '121-301%' 
				and item_no <> '121-301-0240'
				and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
				and no_polisi <> 'S11LO'
				and sold_to like '0000000%'
				group by PLANT,Propinsi_to
			)tb2 on(KD_PLANT=PLANT)
			)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)
			)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
			where realzak>0
		";    
		$queryrealBagP= oci_parse($connm, $sqlrealbagPlant);
		oci_execute($queryrealBagP);		
		while($rowp=oci_fetch_array($queryrealBagP)){            
			 $dataall['REALBAG_PLANTREGIO'][trim($rowp[ID_REGION])][$rowp[KD_PLANT]] +=$rowp[REALZAK];		
			 $dataall['M_REGION'][trim($rowp[ID_REGION])] =$rowp[NM_REGION];		
			 $dataall['M_PLANT'][$rowp[KD_PLANT]] =$rowp[NAME];		
		}  
		return $dataall;
	}
	
	function getTargetBAGPlantREG($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		if($orgv_st=='7'){
			$sqlm = " or KD_PLANT like '5%' ";
		}
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqltargetPlant="
			select * from(
			select tbmm5.*,tbmm6.NAME from(
			select tbmm3.*,tbmm4.nm_region from(
			select tbmm1.*,tbmm2.id_region,tbmm2.nm_prov from (
			select tbyy.*,tbmm.kd_prop from (
			select tb1.*,(tb1.TARGET*tb2.PORSIV) as TARGETH  from (
			select KD_PLANT,ITEM_NO,KD_KOTA,SUM(TARGET) as TARGET from ZREPORT_TARGET_PLANT where 
			BULAN='$bln' and TAHUN='$thn' and BRAN12 is null and KODE_DA is null
			and (KD_PLANT like '$orgv_st%' $sqlm) and ITEM_NO='121-301'
			group by KD_PLANT,ITEM_NO,KD_KOTA
			)tb1 left join (    
				select c.TIPE, SUM(PORSI/total_porsi) as PORSIV from (
					select region,TIPE,PORSI from zreport_porsi_sales_region
					where vkorg ='$com' and region=5
					and BUDAT='$dayKemarin'
				)c left join(
					select region, tipe, sum(porsi) as total_porsi 
					from zreport_porsi_sales_region 
					where budat like '$thn$bln%' and vkorg ='$com' group by region, tipe 
				)d on(c.TIPE=d.TIPE and c.REGION=d.REGION)
				group by c.TIPE
			)tb2 on (tb1.ITEM_NO=tb2.TIPE)
			)tbyy left join (
				select KD_KOTA,KD_PROP from ZREPORT_M_KOTA group by KD_KOTA,KD_PROP
			)tbmm on (tbyy.KD_KOTA=tbmm.KD_KOTA)
			)tbmm1 left join ZREPORT_M_PROVINSI tbmm2 on(tbmm1.KD_PROP=tbmm2.kd_prov)
			)tbmm3 left join ZREPORT_M_REGION tbmm4 on(tbmm3.id_region=tbmm4.id_region)
			)tbmm5 left join (select KD_PLANT,NAME,KAPASITAS_BAG,KAPASITAS_CURAH  from ZREPORT_M_PLANT where ORG in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin))tbmm6 on(tbmm6.KD_PLANT=tbmm5.KD_PLANT)
			)
			order by KD_PLANT,ITEM_NO
		";    
		$querytargetP= oci_parse($connm, $sqltargetPlant);
		oci_execute($querytargetP);		
		while($rowp=oci_fetch_array($querytargetP)){            
			 $dataall['DATA_TARGETPLANT'][trim($rowp[ID_REGION])][$rowp[KD_PLANT]] +=$rowp[TARGETH];		
			 $dataall['DATA_MREGION'][trim($rowp[ID_REGION])]=$rowp[NM_REGION];		
			 $dataall['DATA_PLANT'][trim($rowp[KD_PLANT])]=$rowp[NAME];		
		}  

		return $dataall;
	}
	
	
	function getMBIRO($connm,$com){
		$dataall=array(
					'1' => 'Biro Wil.1',
					'2' => 'Biro Wil.2',
					'3' => 'Biro Wil.3',
					'4' => 'Biro Wil.4',
					'5' => 'Biro Curah'
				 );

		return $dataall;
	}
	
	function getStokGudang($connm,$sap,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$bulankemaren=(($thn.$bln)-1);
		$bulankemarenb=$bulankemaren."01";
		$lasttglbulnkem=date("Ymt", strtotime($bulankemarenb));	
		$sqlM="
			select tb7.*,nvl(tb8.QTY_STOKAKH,0) as QTY_STOKAKH from (
			select tb5.*,tb6.* from (
			select tb3.*,TB4.ID_PROV,TB4.DESCH,TB4.DESC_AREA from(
			select tb1.*,tb2.kd_area from(
				select * from CRM_GUDANG_SERVICEM where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
			)tb1 left join (
				select * from ZREPORT_M_KOTA where kd_area is not null
			)tb2 on(tb1.kota_shipto=tb2.kd_kota)
			)tb3 left join ZREPORT_M_AREA tb4 on(tb3.kd_area=tb4.kd_area)
			)tb5 left join (
				select tbmp.*,tbreg.nm_region from(
					select kd_prov,nm_prov,id_region from ZREPORT_M_PROVINSI
				)tbmp left join(
					select * from ZREPORT_M_REGION
				)tbreg on(tbmp.id_region=tbreg.id_region)
			)tb6 on(tb5.id_prov=tb6.kd_prov)
			)tb7 left join(
				SELECT org,kode_shipto,TO_CHAR (tgl_rilis,'YYYYMMDD') AS tgl_rilisg,SUM (QTY_STOK) AS QTY_STOKAKH
				FROM   CRM_GUDANG_SERVICE tb1
				WHERE   delete_mark = '0'
				AND TIPEDATA = 'MANUAL'
				and TO_CHAR (tgl_rilis,'YYYYMMDD')='$lasttglbulnkem'
				GROUP BY org,kode_shipto,TO_CHAR (tgl_rilis,'YYYYMMDD')
			)tb8 on(tb7.org=tb8.org and tb7.KODE_SHIPTO=tb8.kode_shipto)
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_STOKREGIONARE'][trim($rowp[ID_REGION])][$rowp[KD_AREA]] +=$rowp[QTY_STOK];		
			 $dataall['DATA_STOKREGIONAREAKHBLN'][trim($rowp[ID_REGION])][$rowp[KD_AREA]] +=$rowp[QTY_STOKAKH];		
			 $dataall['DATA_STOKTOT'] +=$rowp[QTY_STOK];		
			 $dataall['DATA_STOKTOTAKHIRBLN'] +=$rowp[QTY_STOKAKH];		
			 $dataall['DATA_MREGION'][trim($rowp[ID_REGION])]=strtoupper($rowp[NM_REGION]);		
			 $dataall['DATA_MAREA'][trim($rowp[KD_AREA])]=strtoupper($rowp[DESCH]);		
			 $dataall['DATA_SHIPTO'][trim($rowp[KODE_SHIPTO])]=strtoupper($rowp[NAMA_SHIPTO]);		
			 $dataall['DATA_SHIPTOA'][trim($rowp[ID_REGION])][$rowp[KD_AREA]][trim($rowp[KODE_SHIPTO])]['NAMASHIPTO']=strtoupper($rowp[NAMA_SHIPTO]);		
		}  

		//kapasitas gudang
		if(count($dataall['DATA_SHIPTO'])>0){
			$kapgudang = $this->getShipto($sap,$dataall['DATA_SHIPTO'],$com);
			if(count($dataall['DATA_SHIPTOA'])>0){
				foreach($dataall['DATA_SHIPTOA'] as $idregio => $valreg){
				foreach($valreg as $idare => $valare){
				foreach($valare as $idshipto => $val){
					$dataall['DATA_SHIPTOA'][trim($idregio)][$idare][trim($idshipto)]['STOKKAPTO'] =@(($kapgudang[$idshipto]['QTY_GUD']*40)/1000);
					$dataall['DATA_KAPSITAA'][trim($idregio)][$idare] +=@(($kapgudang[$idshipto]['QTY_GUD']*40)/1000);
					$dataall['DATA_TOTKAPSITO'][trim($idregio)] +=@(($kapgudang[$idshipto]['QTY_GUD']*40)/1000);
				}
				}
				}

			}	
		}		
		return $dataall;
	}
	
	function getStokGudangKem($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		//$tglkemaren = date("Ymd",strtotime("$dayKemarin -1 day"));
		$sqlM="
			    SELECT org,SUM (QTY_STOK) AS QTY_STOKKEM
				FROM   CRM_GUDANG_SERVICE tb1
				WHERE   delete_mark = '0'
				AND TIPEDATA = 'MANUAL'
				and TO_CHAR (tgl_rilis,'YYYYMMDD')='$dayKemarin'
				and org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
				GROUP BY org
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_TOTSTOKKEM'] =$rowp[QTY_STOKKEM];				
		}  	
		return $dataall;
	}
	
	function getShipto($sap,$shipto,$orgse){
		if($sap) {
		$fce = &$sap->NewFunction ("Z_ZAPPSD_SHOW_KAPASITAS");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}

		//header entri    
		if(count($shipto)>0){
		foreach ($shipto as $key => $value) {
				$fce->I_KUNNR->row["SIGN"] = "I";
				$fce->I_KUNNR->row["OPTION"] = "EQ";
				$fce->I_KUNNR->row["LOW"] = sprintf('%010d',$key);
				$fce->I_KUNNR->Append($fce->I_KUNNR->row); 
		}
		$fce->Call();
		unset($dataShitpcek);
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->RETURN_DATA->Reset();
				while ( $fce->RETURN_DATA->Next() ){
					$dataShitpcek[$fce->RETURN_DATA->row['KUNNR']]=$fce->RETURN_DATA->row;
				 }

		} else 
			$fce->PrintStatus();

		}
		$fce->Close();
		
		return $dataShitpcek;
	}
	
	function getMPabrikTuban($connm,$plant){
		$dataall=array(
					'7403' => array(
								'1' => array('NAMA'=>'Tuban 1','CONV'=>array('80' => 'PPC','90' => 'OPC Plus'),'JMPACKER'=>'8'),
								'2' => array('NAMA'=>'Tuban 2','CONV'=>array('81' => 'PPC','91' => 'OPC'),'JMPACKER'=>'8'),
								'3' => array('NAMA'=>'Tuban 3','CONV'=>array('82' => 'PPC','92' => 'OPC'),'JMPACKER'=>'5'),
								'4' => array('NAMA'=>'Tuban 4','CONV'=>array('84' => 'PCC','94' => 'OPC'),'JMPACKER'=>'4'),
							),
                    '5401' => array(
								'01' => array('NAMA'=>'PM 1','CONV'=>array('90' => 'PPC'),'JMPACKER'=>'8'),
								'02' => array('NAMA'=>'PM 2','CONV'=>array('91' => 'PCC'),'JMPACKER'=>'8'),
								'03' => array('NAMA'=>'PM 3','CONV'=>array('92' => 'OPC'),'JMPACKER'=>'5'),
								'04' => array('NAMA'=>'PM 4','CONV'=>array('97' => 'KLINKER'),'JMPACKER'=>'4'),
							)
				 );

		return $dataall;
	}
    
    function getRealPlantZakCur($connm,$com,$plant,$dayKemarin,$material){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqlM="
			select PLANT,LOADING_POINT,sum(kwantumx) as realto,sum(kwantum) as realzak from zreport_rpt_real where
			TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			and item_no like '$material' 
			and com ='$com'
			and plant='$plant'
			and NO_POLISI<>'S11LO'
			and order_type <>'ZNL'
			and sold_to like '0000000%'			 
			group by PLANT,LOADING_POINT                        
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_REALCONV'][$rowp[PLANT]][$rowp[LOADING_POINT]] +=$rowp['REALTO'];				
		}  	
		return $dataall;
	}
	
	function getRealPlantCurhD($connm,$com,$plant,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqlM="
			select PLANT,LOADING_POINT,sum(kwantumx) as realcur from zreport_rpt_real where
			TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			and item_no like '121-302%' 
			and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and plant='$plant'
			and NO_POLISI<>'S11LO'
			and order_type <>'ZNL'
			and sold_to like '0000000%'			 
			group by PLANT,LOADING_POINT                        
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_REALCONV'][$rowp[PLANT]][$rowp[LOADING_POINT]] +=$rowp['REALCUR'];				
		}  	
		return $dataall;
	}
	
	function getRealPlantCurhProd($connm,$com,$plant,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqlM="
			select PLANT,LOADING_POINT,sum(kwantumx) as realcur from zreport_rpt_real where
			TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			and item_no like '121-302%' 
			and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and plant='$plant'
			and NO_POLISI<>'S11LO'			 
			group by PLANT,LOADING_POINT                        
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_REALCONV'][$rowp[PLANT]][$rowp[LOADING_POINT]] +=$rowp['REALCUR'];				
		}  	
		return $dataall;
	}

	
	function getRealPlantZAKD($connm,$com,$plant,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		$sqlM="
			select PLANT,sum(kwantumx) as REALZAK from zreport_rpt_real where
			TGL_SPJ=to_date('$dayKemarin','yyyymmdd')
			and com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			and plant='$plant'
			and NO_POLISI<>'S11LO'
			and item_no like '121-301%' 
			and item_no <> '121-301-0240'
			group by PLANT                        
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_REALCONV'][$rowp[PLANT]] +=$rowp['REALZAK'];				
		}  	
		return $dataall;
	}
	
	function getTargetRealisasisgRKAP($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select tb3.*,tb4.nm_region from(
		select prov,id_region,budat,item_no,sum(target_real) as target_realto from (
		select tb1.*,tb2.id_region from (
		
			 select a.prov, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_real ,d.tipe as item_no
			 from (
				select $com as co,bln,thn,prov,tipe,quantum from sap_t_rencana_sales_type
				where co in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) and thn='$thn' and prov!='1092' and prov!='0001'
				and bln='$bln'
			 ) a left join zreport_m_provinsi b on a.prov = b.kd_prov 
			 left join zreport_porsi_sales_region c on c.region=5 and c.vkorg= a.co 
			 and c.budat like '$thn$bln%' and c.tipe = a.tipe left join (
			 select region, tipe, sum(porsi) as total_porsi 
			 from zreport_porsi_sales_region 
				 where budat like '$thn$bln%' and vkorg ='$com' group by region, tipe 
			 )d on c.region = d.region 
			 and d.tipe = a.tipe where co = '$com' and thn = '$thn' and bln = '$bln' 
			 group by co, thn, bln, a.prov, c.budat ,d.tipe 
			 
		)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)
		)
		group by prov,id_region,budat,item_no
		)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
		order by tb3.prov,tb3.id_region,budat,item_no	 
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_TARGET'][$rowt[BUDAT].$rowt[ID_REGION].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TARGETPROP'][$rowt[PROV].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TOTTARGET'][$rowt[ID_REGION].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];	
			$dataall['DATA_TOTTARGETPROP'][$rowt[PROV].$rowt[ITEM_NO]] +=$rowt[TARGET_REALTO];
            $dataall['DATA_TARGETPROPBUD'][$rowt[PROV].$rowt[ITEM_NO].$rowt[BUDAT]] +=$rowt[TARGET_REALTO];
		}
		return $dataall;
	}
	
	function getPackerTuban($sap,$orgse,$date){
		if($sap) {
		$fce = &$sap->NewFunction ("Z_ZAPPSD_RELEASESEMEN_HARIAN");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}

		//header entri 
		$fce->FI_CREATE_DATE=$date;
        $fce->P_BUKRS=$orgse;
			
		$fce->Call();
		unset($data);
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->FT_RSCONTENT_TOTAL->Reset();
				while ( $fce->FT_RSCONTENT_TOTAL->Next() ){
					$data['FT_RSCONTENT_TOTAL'][$fce->FT_RSCONTENT_TOTAL->row['PACKER']]=$fce->FT_RSCONTENT_TOTAL->row;
				 }

		} else 
			$fce->PrintStatus();

		
		$fce->Close();
		
		return $data;
	}
	
	function getTargetPMPorsi($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
        
        if($com == '7000'){
          $tot = 32000; 
        }else if($com == '5000'){
          $tot = 6000;   
        }
        
		$sqltarget="
		select c.*,c.m*c.porsi as TARGET_PMTO from (
		select budat,($tot) as M ,porsi
		from zreport_porsi_sales_region where region=5 and vkorg = '$com' and budat = '$datekemarin'
		and tipe='121-301'
		)c
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_TARGETPM'][$rowt[BUDAT]] =$rowt[TARGET_PMTO];	
		}
		return $dataall;
	}
	
	function getStokMaterial($sap,$orgse,$material){
		if($sap) {
		$fce = &$sap->NewFunction ("ZCMM_MATERIAL_STOCK");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}

		//header entri 
		$fce->I_MATERIAL->row["SIGN"] = "I";
		$fce->I_MATERIAL->row["OPTION"] = "EQ";
		$fce->I_MATERIAL->row["LOW"] = $material;
		$fce->I_MATERIAL->Append($fce->I_MATERIAL->row);
		
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "BT";
		$fce->I_WERKS->row["LOW"] = '7301';
		$fce->I_WERKS->row["HIGH"] = '7305';
		$fce->I_WERKS->Append($fce->I_WERKS->row); 
			
		$fce->Call();
		unset($data);
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->T_OUT->Reset();
				while ( $fce->T_OUT->Next() ){
					$data['T_OUT'][$fce->T_OUT->row['BWKEY']] =$fce->T_OUT->row;
					if( $fce-> T_OUT->row['BWKEY']!='7301'){
						$data['TOT_OUTTUBAN'] +=$fce->T_OUT->row['LBKUM']*1;
						$data['TOT_OUTTUBAND'][$fce->T_OUT->row['BWKEY']] =$fce->T_OUT->row['LBKUM']*1;
					}
					if( $fce->T_OUT->row['BWKEY']=='7301'){
						$data['T_OUTGRESIK']=$fce->T_OUT->row;
					}
				 }

		} else 
			$fce->PrintStatus();

		
		$fce->Close();
		
		return $data;
	}
	
	function getStokMaterialBatubara($sap,$orgse,$plant){
		if($sap) {
		$fce = &$sap->NewFunction ("ZCMM_MATERIAL_STOCK");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}
		//header entri 
		$fce->I_MATERIAL->row["SIGN"] = "I";
		$fce->I_MATERIAL->row["OPTION"] = "EQ";
		$fce->I_MATERIAL->row["LOW"] = '112-100-0013';
		$fce->I_MATERIAL->Append($fce->I_MATERIAL->row);
		$fce->I_MATERIAL->row["SIGN"] = "I";
		$fce->I_MATERIAL->row["OPTION"] = "EQ";
		$fce->I_MATERIAL->row["LOW"] = '112-100-0010';
		$fce->I_MATERIAL->Append($fce->I_MATERIAL->row);
		$fce->I_MATERIAL->row["SIGN"] = "I";
		$fce->I_MATERIAL->row["OPTION"] = "EQ";
		$fce->I_MATERIAL->row["LOW"] = '112-100-0009';
		$fce->I_MATERIAL->Append($fce->I_MATERIAL->row);
		$fce->I_MATERIAL->row["SIGN"] = "I";
		$fce->I_MATERIAL->row["OPTION"] = "EQ";
		$fce->I_MATERIAL->row["LOW"] = '112-100-0012';
		$fce->I_MATERIAL->Append($fce->I_MATERIAL->row);
		
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "EQ";
		$fce->I_WERKS->row["LOW"] = $plant;
		$fce->I_WERKS->Append($fce->I_WERKS->row); 
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "EQ";
		$fce->I_WERKS->row["LOW"] = '7302';
		$fce->I_WERKS->Append($fce->I_WERKS->row); 
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "EQ";
		$fce->I_WERKS->row["LOW"] = '7303';
		$fce->I_WERKS->Append($fce->I_WERKS->row); 
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "EQ";
		$fce->I_WERKS->row["LOW"] = '7304';
		$fce->I_WERKS->Append($fce->I_WERKS->row); 
		$fce->I_WERKS->row["SIGN"] = "I";
		$fce->I_WERKS->row["OPTION"] = "EQ";
		$fce->I_WERKS->row["LOW"] = '7305';
		$fce->I_WERKS->Append($fce->I_WERKS->row);	
		$fce->Call();
		
		unset($data);
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->T_OUT->Reset();
				while ( $fce->T_OUT->Next() ){
					$data['T_OUT'][$fce->T_OUT->row['BWKEY']][] =$fce->T_OUT->row;
					$data['TOT_OUTTUBAN'] +=$fce->T_OUT->row['LBKUM']*1;
					$data['TOT_OUTTUBAND'][$fce->T_OUT->row['BWKEY']] +=$fce->T_OUT->row['LBKUM']*1;	
				}

		} else 
			$fce->PrintStatus();

		$fce->Close();		
		return $data;
	}
	
	
	function getStokSiloSemen($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select tbm.*,tbnn.stok from (
		select KD_PLANT,NAME,KAPASITAS_SILO from ZREPORT_M_PLANT  where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
		and kd_plant not in ('7301')
		)tbm left join (
		   select PLANT,sum (stok) as stok from(
		   select nmplan as PLANT, sum (qty_entry) as stok
		   from zreport_stock_silo
		   where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
		   and create_date = to_date('$datekemarin','YYYYMMDD') and nmplan not in ('7301')
		   group by nmplan
		   union
		   select WERKS as PLANT,SUM(TOTAL) as stok from ROMA_SILO_DAY2DAYX
		   where to_char(create_date,'YYYYMMDD')='$datekemarin'
		   group by WERKS
		   )
		   group by PLANT
		)tbnn on(tbm.kd_plant=tbnn.PLANT)
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_STOKSILO'][$rowt[KD_PLANT]] =$rowt[STOK];	
			$dataall['DATA_MPLANT'][$rowt[KD_PLANT]] = $rowt[NAME];	
			$dataall['DATA_KAPSILOPLANT'][$rowt[KD_PLANT]] = $rowt[KAPASITAS_SILO];	
		}
		return $dataall;
	}
	
	function getLastStokSiloSemen($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select tbm.*,tbnn.STOCK_SILO from (
				select KD_PLANT,NAME from ZREPORT_M_PLANT  where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
		)tbm left join (
		Select ORG,NMPLAN,sum(STOCK_SILO) as STOCK_SILO from(
		With STOCK as (      
			  SELECT ORG,NMPLAN,TIPE,CREATE_DATE,SILO, QTY_ENTRY,
			  ROW_NUMBER() OVER(PARTITION BY ORG,NMPLAN,TIPE,SILO ORDER BY CREATE_DATE DESC) AS ranks 
			  FROM ZREPORT_STOCK_SILO
			  WHERE SILO <> '00000SILOS'
			  GROUP BY ORG,NMPLAN, TIPE,CREATE_DATE,SILO,QTY_ENTRY )
							Select ORG,NMPLAN,TIPE,SUM(QTY_ENTRY) AS STOCK_SILO from STOCK 
							where ranks=1
							group by ORG,NMPLAN,TIPE
							order by ORG,NMPLAN,TIPE
		)where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) 
		group by ORG,NMPLAN
		)tbnn on(tbm.kd_plant=tbnn.nmplan)
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_STOKSILO'][$rowt[KD_PLANT]] =$rowt[STOCK_SILO];	
			$dataall['DATA_MPLANT'][$rowt[KD_PLANT]] =$rowt[NAME];	
		}
		return $dataall;
	}
	
	function getLastStokSiloSemenTipe($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select tbm.*,tbnn.TIPE,tbnn.STOCK_SILO from (
				select KD_PLANT,NAME from ZREPORT_M_PLANT  where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
		)tbm left join (
		Select ORG,NMPLAN,TIPE,sum(STOCK_SILO) as STOCK_SILO from(
		With STOCK as (      
			  SELECT ORG,NMPLAN,TIPE,CREATE_DATE,SILO, QTY_ENTRY,
			  ROW_NUMBER() OVER(PARTITION BY ORG,NMPLAN,TIPE,SILO ORDER BY CREATE_DATE DESC) AS ranks 
			  FROM ZREPORT_STOCK_SILO
			  WHERE SILO <> '00000SILOS' and nmplan not in ('7301')
			  GROUP BY ORG,NMPLAN, TIPE,CREATE_DATE,SILO,QTY_ENTRY )
							Select ORG,NMPLAN,TIPE,SUM(QTY_ENTRY) AS STOCK_SILO from STOCK 
							where ranks=1
							group by ORG,NMPLAN,TIPE
							order by ORG,NMPLAN,TIPE
		)where org in(select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
		group by ORG,NMPLAN,TIPE
		)tbnn on(tbm.kd_plant=tbnn.nmplan)
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_STOKSILO'][$rowt[KD_PLANT]] +=$rowt[STOCK_SILO];	
			$dataall['DATA_STOKTIPESILO'][$rowt[KD_PLANT]][$rowt[TIPE]] +=$rowt[STOCK_SILO];	
			$dataall['DATA_MPLANT'][$rowt[KD_PLANT]] =$rowt[NAME];	
		}
		return $dataall;
	}
	
	
	function getKonveyorST($connm,$com,$plant,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select * from ZREPORT_M_CVY_MAT where nmplan='$plant' and MATNR is not null
		order by pabrik,line_boomer
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){  
			if(trim($rowt[PABRIK])!=''){
				$dataall['DATA_KEYMKONV'][trim($rowt[LINE_BOOMER])] =$rowt[trim($rowt[LINE_BOOMER])];	
				$dataall['DATA_MKONV'][trim($rowt[LINE_BOOMER])] =$rowt;	
				$dataall['DATA_PMKONV'][trim($rowt[PABRIK])][trim($rowt[LINE_BOOMER])] =$rowt[trim($rowt[PABRIK])];	
			}
		}
		return $dataall;
	}
	
	function getStatusAntrianPacker($sap,$orgse,$plant){
		
		if($sap) {
		$fce = $sap->NewFunction("Z_ZAPPSD_SELECT_CVY");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}
		$fce->XDATA_APP["NMORG"] = $orgse;
		$fce->XDATA_APP["NMPLAN"] = $plant;

		$aConv = array();
		$fce->Call();
		if ($fce->GetStatus() == SAPRFC_OK) {
		  $fce->RETURN_DATA->Reset();
		  while ($fce->RETURN_DATA->Next()) {
			$lb = $fce->RETURN_DATA->row["LINE_BOOMER"];
			$aConv[$lb] = $fce->RETURN_DATA->row;
		  }
		}
		$fce->Close();
		
		
		$aStatus = array('0' => 'OFF', '10' => 'ON');
		$aJenis = array('10' => 'NON PROYEK', '20' => 'PROYEK / NON PROYEK');
		if($sap) {
		$fce = &$sap->NewFunction("Z_ZAPPSD_SEL_CVY_MAT");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}
		$fce->X_PARAM["NMORG"] = $orgse;
		$fce->X_PARAM["NMPLAN"] = $plant;

		$fce->Call();
		$sCvy = array();
		if ($fce->GetStatus() == SAPRFC_OK) {
		  $fce->RETURN_DATA->Reset();
		  //Display Tables
		  while ($fce->RETURN_DATA->Next()) {
			$kd = trim($fce->RETURN_DATA->row["LINE_BOOMER"]);
			$sCvy[$kd]["NO"] = $kd;
			$sCvy[$kd][40] = 0;
			$sCvy[$kd][50] = 0;
			$sCvy[$kd]["JUMLAH"] = 0;
			$sCvy[$kd]["IDEAL"] = $aConv[$kd]["KAPASITAS"];
			$sCvy[$kd]["STATUS"] = $aStatus[$aConv[$kd]["STATUS"]];
			$sCvy[$kd]["DESC1"] = $fce->RETURN_DATA->row["MAKTX"];
			$sCvy[$kd]["DESC2"] = $fce->RETURN_DATA->row["DESC2"];
		  }
		  //usort($sCvy, "myCompare");
		}
		
		
		if($sap) {
		$fce = &$sap->NewFunction ("Z_ZAPPSD_SEL_TRNS_HDR3");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}
		//header entri 
		$fce->XDATA_APP["NMORG"] = $orgse;
		$fce->XDATA_APP["NMPLAN"] = $plant;
		$fce->XPARAM['POSNR'] = '000010';
		$fce->XPARAM['STATUS_TRANS'] = '40';
		$fce->Call();
		$fce->XPARAM['STATUS_TRANS'] = '50';
		$fce->Call();
		$fce->XPARAM['STATUS_TRANS'] = '55';
		$fce->Call();			
		unset($data);unset($aJml);
		$aJml = array("NO"=>"JML ANTRI",40=>0,50=>0,"JUMLAH"=>0,"TIPETRUK");
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->RETURN_DATA->Reset();
				while ( $fce->RETURN_DATA->Next() ){
					$kd = trim($fce->RETURN_DATA->row["LOADING_POINT"]);	
					//konveyor klinker rembang diabaikan
					if($kd=='97' and $plant=='5401'){
						continue;
					}	
					if (!isset($sCvy[$kd]))
					  continue;
					$st = $fce->RETURN_DATA->row["STATUS_TRANS"];
					if($st=='55'){
						$st = '50';
					}
					$sCvy[$kd][$st]++;
					$aJml[$st]++;
					$sCvy[$kd]["JUMLAH"]++;
					$aJml["JUMLAH"]++;	

						
				}

		} else 
			$fce->PrintStatus();

		$data['DATA_DETALKONV']=$sCvy;
		$data['DATA_RESUMKONV']=$aJml;
		$fce->Close();		
		return $data;
	}
	
	function getPMPabTuban($connm,$plant){
		$dataall=array(
					'7403' => array(
								'1' => array('NAMA'=>'Tuban 1','SILO'=>array('1' => 'PPC','2' => 'PPC','3' => 'OPC','4' => 'PPC'),'KAPASITAS'=>'64000'),
								'2' => array('NAMA'=>'Tuban 2','SILO'=>array('5' => 'PPC','6' => 'PPC','7' => 'OPC','8' => 'PPC'),'KAPASITAS'=>'64000'),
								'3' => array('NAMA'=>'Tuban 3','SILO'=>array('9' => 'OPC','10' => 'PPC','11' => 'OPC','12' => 'PPC'),'KAPASITAS'=>'64000'),
								'4' => array('NAMA'=>'Tuban 4','SILO'=>array('13' => 'PPC','14' => 'PPC','15' => 'OPC','16' => 'OPC'),'KAPASITAS'=>'72000'),
								'PELABUHAN' => array('NAMA'=>'PELABUHAN','SILO'=>'','KAPASITAS'=>'18000')
							),
					'5401' => array(
								'1' => array('NAMA'=>'Rembang 1','SILO'=>array('1' => 'PPC','2' => 'OPC','3' => 'OPC'),'KAPASITAS'=>'60000')
							),		
					'7415' => array(
								'1' => array('NAMA'=>'CIGADING 1','SILO'=>array('1' => 'PPC','2' => 'PPC'),'KAPASITAS'=>'30000')
							),		
							
					'3301' => array(
								//'1' => array('NAMA'=>'INDARUNG 1','MPLANT'=>'3301','KAPASITAS'=>'64000'),
								//'2' => array('NAMA'=>'INDARUNG 2','MPLANT'=>'3302','KAPASITAS'=>'64000'),
								'3' => array('NAMA'=>'INDARUNG II/III/IV','MPLANT'=>'3303','KAPASITAS'=>'53000'), 
								'4' => array('NAMA'=>'INDARUNG V','MPLANT'=>'3304','KAPASITAS'=>'59000'),
                                '5' => array('NAMA'=>'INDARUNG VI','MPLANT'=>'3305','KAPASITAS'=>'30000')
							),
                     //@pnambahan tonasa
                    '4301' => array(
								//'1' => array('NAMA'=>'INDARUNG 1','MPLANT'=>'3301','KAPASITAS'=>'64000'),
								//'2' => array('NAMA'=>'INDARUNG 2','MPLANT'=>'3302','KAPASITAS'=>'64000'),
								'3' => array('NAMA'=>'TONASA II/III','MPLANT'=>'4301','KAPASITAS'=>'53000'), 
								'4' => array('NAMA'=>'TONASA IV','MPLANT'=>'4302','KAPASITAS'=>'59000'),
                                '5' => array('NAMA'=>'TONASA V','MPLANT'=>'4303','KAPASITAS'=>'30000')
							)
                   
				 );

		return $dataall;
	}
	
	function getLapSiloHarian($sap,$orgse,$date){
		if($sap) {
		$fce = &$sap->NewFunction ("Z_ZAPPSD_DISPLAY_SILO");
		if ($fce == false ) { $sap->PrintStatus(); exit; }
		}

		//header entri 
		$fce->FI_CREDA=$date;
		$fce->FI_ENDDA=$date;
		$fce->FI_DAY2DAY='X';
			
		$fce->Call();
		unset($data);
		if ($fce->GetStatus() == SAPRFC_OK ) {		
				$fce->FT_DAY->Reset();
				while ( $fce->FT_DAY->Next() ){
					
					$data['FT_DAY'][trim($fce->FT_DAY->row['PACKER'])]['OPC']=($fce->FT_DAY->row['SILO1_OPC']+$fce->FT_DAY->row['SILO2_OPC']+$fce->FT_DAY->row['SILO3_OPC']+$fce->FT_DAY->row['SILO4_OPC']);
					$data['FT_DAY'][trim($fce->FT_DAY->row['PACKER'])]['PPC']=($fce->FT_DAY->row['SILO1_PPC']+$fce->FT_DAY->row['SILO2_PPC']+$fce->FT_DAY->row['SILO3_PPC']+$fce->FT_DAY->row['SILO4_PPC']);
                    $data['FT_DAY'][trim($fce->FT_DAY->row['PACKER'])]['PCC']=($fce->FT_DAY->row['SILO1_PCC']+$fce->FT_DAY->row['SILO2_PCC']+$fce->FT_DAY->row['SILO3_PCC']+$fce->FT_DAY->row['SILO4_PCC']);
					$data['FT_TOTDAY']+=$fce->FT_DAY->row['TOTAL'];
				 }

		} else 
			$fce->PrintStatus();

		
		$fce->Close();
		
		return $data;
	}
	
	function getStatusPMcv($connm,$com,$plant){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="
		select * from ZREPORT_PM where PLANT='$plant'
		and delete_mark=0
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){  
				$dataall['DATA_MPM'][$rowt['PABRIK']][$rowt['KODE']]['STATUS']=$rowt['STATUS'];	
		}
		return $dataall;
	}
	
	function getStokPERSiloSemen($connm,$com,$datekemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$sqltarget="			
			select tbm.*,tbnn.SILO,tbnn.stok from (
			  select KD_PLANT,NAME,KAPASITAS_SILO from ZREPORT_M_PLANT  where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			)tbm left join (
			  select PLANT,SILO,sum (stok) as stok from(
			   select nmplan as PLANT, SILO,sum (qty_entry) as stok
			   from zreport_stock_silo
			   where org in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin)
			   and create_date = to_date('$datekemarin','YYYYMMDD') and nmplan not in ('7301')
			   group by nmplan,SILO
			   union
			   select WERKS as PLANT,GROUP_SILO as SILO,SUM(TOTAL) as stok from ROMA_SILO_DAY2DAYX
			   where to_char(create_date,'YYYYMMDD')='$datekemarin'
			   group by WERKS,GROUP_SILO
			  )
			  group by PLANT,SILO
			)tbnn on(tbm.kd_plant=tbnn.PLANT)
		
		";    
		$querytarget= oci_parse($connm, $sqltarget);
		oci_execute($querytarget);		
		while($rowt=oci_fetch_array($querytarget)){            
			$dataall['DATA_MSILOPLANT'][$rowt[KD_PLANT]][$rowt[SILO]] =$rowt[STOK];	
			$dataall['DATA_MPLANT'][$rowt[KD_PLANT]] = $rowt[NAME];	
			$dataall['DATA_KAPSILOPLANT'][$rowt[KD_PLANT]] = $rowt[KAPASITAS_SILO];	
		}
		return $dataall;
	}
	
	function getLevelStokGudang($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		//$tglkemaren = date("Ymd",strtotime("$dayKemarin -1 day"));
		$sebulanseblumnya = date("Ym", strtotime(date("Ymd", strtotime($dayKemarin)) . " -1 month")); // 1 bulan sebelumnya
		if($thn!='' && $bln!=''){
			$sqlfilter .=" and to_char(date_update,'YYYYMM')='$sebulanseblumnya' ";
			
		}
		$sqlM="
			select tb3.*,tb4.NM_PROV,tb4.ID_REGION,tb4.NM_REGION from(
			select tb1.*,tb2.DESC_AREA,tb2.DESCH,tb2.ID_PROV,tb2.NO_AREA from(
			With STOCKAREA as ( 
				select com,date_update,kd_area,tipe,STOK_PERSEN, 
				ROW_NUMBER() OVER(PARTITION BY com,kd_area,tipe ORDER BY date_update DESC) AS ranks 
				from ZREPORT_STOKGUD_AREA where com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) and delete_mark='0' $sqlfilter
				GROUP BY com,date_update,kd_area,tipe,STOK_PERSEN )
				Select com,date_update,kd_area,tipe,SUM(STOK_PERSEN) AS STOK_PERSEN from STOCKAREA 
				where ranks=1
				group by com,date_update,kd_area,tipe
				order by com,date_update,kd_area,tipe
			)tb1 left join ZREPORT_M_AREA tb2 on(tb1.kd_area=tb2.KD_AREA)
			)tb3 left join (
			  select tbmp.*,tbreg.nm_region from(
				 select kd_prov,nm_prov,id_region from ZREPORT_M_PROVINSI
			  )tbmp left join(
				 select * from ZREPORT_M_REGION
			  )tbreg on(tbmp.id_region=tbreg.id_region)
			)tb4 on(tb3.ID_PROV=tb4.kd_prov)
			order by ID_REGION,NO_AREA
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){
			 $dataall['DATA_STOKAREA'][$rowp[ID_REGION]][$rowp[KD_AREA]]+= $rowp[STOK_PERSEN];				
			 $dataall['DATA_TIPESTOKAREA'][$rowp[COM]][$rowp[KD_AREA]][$rowp[TIPE]]+= $rowp[STOK_PERSEN];				
			 $dataall['DATA_ALLSTOKAREA'][$rowp[COM]]+= $rowp[STOK_PERSEN];				
			 $dataall['DATA_MSREGION'][$rowp[ID_REGION]]= $rowp[NM_REGION];				
			 $dataall['DATA_MSAREA'][$rowp[KD_AREA]]= $rowp[DESC_AREA];				
		}  	
		return $dataall;
	}
	
	function getLevelStokGudangReg($connm,$com,$dayKemarin){
		$orgv_st=substr($com,0,1);
		unset($dataall);
		$thn = substr($dayKemarin,0,4);
		$bln = substr($dayKemarin,4,2);
		$tgl = sprintf("%02d", substr($dayKemarin,6,2));
		//$tglkemaren = date("Ymd",strtotime("$dayKemarin -1 day"));
		$sebulanseblumnya = date("Ym", strtotime(date("Ymd", strtotime($dayKemarin)) . " -1 month")); // 1 bulan sebelumnya
		if($thn!='' && $bln!=''){
			$sqlfilter .=" and to_char(date_update,'YYYYMM')='$sebulanseblumnya' ";
		}
		$sqlM="
			select * from (
			With STOCKREGION as ( 
                select com,date_update,KD_REGION,tipe,STOK_PERSEN, 
                ROW_NUMBER() OVER(PARTITION BY com,KD_REGION,tipe ORDER BY date_update DESC) AS ranks 
                from ZREPORT_STOKGUD_REG where com in (select orgin from ZREPORT_M_INCOM where orgm='$com' and delete_mark=0 group by orgin) and delete_mark='0' $sqlfilter
                GROUP BY com,date_update,KD_REGION,tipe,STOK_PERSEN )
                Select com,date_update,KD_REGION,tipe,SUM(STOK_PERSEN) AS STOK_PERSEN from STOCKREGION 
                where ranks=1
                group by com,date_update,KD_REGION,tipe
                order by com,date_update,KD_REGION
			)
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_STOKREGION'][$rowp[KD_REGION]] += $rowp[STOK_PERSEN];				
			 $dataall['DATA_TIPESTOKREGION'][$rowp[COM]][$rowp[KD_REGION]][$rowp[TIPE]]+= $rowp[STOK_PERSEN];							
		}  	
		return $dataall;
	}
	
	function getMasterProp($connm,$com){
		$orgv_st=substr($com,0,1);
		$sqlM="
		select kd_prov,nm_prov,biro_sco,biro_sco_sp from ZREPORT_M_PROVINSI
		";    
		$queryM= oci_parse($connm, $sqlM);
		oci_execute($queryM);		
		while($rowp=oci_fetch_array($queryM)){            
			 $dataall['DATA_MASTREPROP'][$rowp[KD_PROV]] = $rowp[NM_PROV];				
			 $dataall['DATA_MASTREPROPBIRO'][$rowp[KD_PROV]]= $rowp[BIRO_SCO];							
			 $dataall['DATA_MASTREPROPBIRO_SP'][$rowp[BIRO_SCO_SP]][$rowp[KD_PROV]]= $rowp[KD_PROV];							
			 $dataall['DATA_MASTREBIROPROP'][$rowp[BIRO_SCO]][$rowp[KD_PROV]]= $rowp[KD_PROV];							
		}  	
		return $dataall;
	}
	
	
	function getTarget_Biro($conn,$org,$item,$dateNow,$biro){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
		if($org=='7000'){
			$sqlm = " or substr(KD_PLANT,0,1) = substr('5',0,1)  ";
		}
        $sqlquery="
        select * from (
		select tbmain.*,tbmare.* from (
		select tbtarget.*, nvl(tbreal.realto,0) as realto from(
		select tb1.*,tb2.budat,tb2.porsiv,nvl((tb1.TARGET*tb2.PORSIV),0) as TARGETHARIAN from(
		--target zak
		SELECT kd_kota,ITEM_NO,sum(target) as target from ZREPORT_TARGET_PLANT WHERE (substr(KD_PLANT,0,1) = substr('$org',0,1) $sqlm)
		and TAHUN = '$thn' and  BULAN = '$bln' and ITEM_NO = '$item' and BRAN12 is null and KODE_DA is null
		group by kd_kota,ITEM_NO
		)tb1 left join (
			--porsi harian
			select c.budat,c.TIPE, SUM(PORSI/total_porsi) as PORSIV from (
				select budat,region,TIPE,PORSI from zreport_porsi_sales_region
				where vkorg ='$org' and region=5
				and BUDAT BETWEEN '".$periode."01' and '$dateNow'
			)c left join(
				select region, tipe, sum(porsi) as total_porsi 
				from zreport_porsi_sales_region 
				where budat like '".$periode."%' and region=5 and vkorg ='$org' group by region, tipe 
			)d on(c.TIPE=d.TIPE and c.REGION=d.REGION)
			group by c.budat,c.TIPE
		)tb2 on(tb2.TIPE=tb1.ITEM_NO)
		)tbtarget left join (
			-- realisai
			select kota,substr(item_no,0,7) as item_no, to_char(tgl_cmplt,'yyyymmdd') as budat, sum(kwantumx) as realto
			from zreport_rpt_real 
			where         
			to_char(tgl_cmplt,'YYYYMMDD') between '".$periode."01' and '$dateNow'
			and ( (order_type <>'ZNL' and
			(item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
			and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and no_polisi <> 'S11LO'
			and sold_to like '0000000%' 
			AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')group by prov)
			group by kota,substr(item_no,0,7),to_char(tgl_cmplt,'yyyymmdd')
		)tbreal on (tbtarget.kd_kota=tbreal.kota and tbtarget.item_no=tbreal.item_no and tbreal.item_no='$item' and tbtarget.budat=tbreal.budat)
		)tbmain left join (
			select tbkota.*,tbprop.nm_prov,tbprop.nm_prov_1,tbprop.urut,tbprop.biro_sco from (
				select tbkt.*,tbare.desch,tbare.no_area,tbare.desc_area from(
					select kd_prop,kd_kota as kdkota,nm_kota,KD_AREA from ZREPORT_M_KOTA
				)tbkt left join (
					select kd_area,desch,no_area,desc_area from ZREPORT_M_AREA
				)tbare on (tbkt.KD_AREA=tbare.kd_area)
			)tbkota left join ZREPORT_M_PROVINSI tbprop on(tbkota.kd_prop=tbprop.kd_prov)
		)tbmare on(tbmain.kd_kota=tbmare.kdkota)
		)
		order by kd_kota,budat asc
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['REKAP_AREALALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['TARGET'] += $row['TARGETHARIAN'];
			$dataall['REKAP_AREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKAP_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKPDETAIL_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['BUDAT']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKPDETAIL_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['BUDAT']][$row['KD_KOTA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKP_KOTA'][$row['KD_KOTA']]= $row['NM_KOTA'];	 
			$dataall['REKP_PROP'][$row['KD_KOTA']]= $row['NM_PROV'];	 
			$dataall['REKP_AREA'][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREABIRO'][$row['BIRO_SCO']][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREAKOTA'][$row['KD_AREA']][$row['KD_KOTA']]= $row['KD_KOTA'];	 
			
						
			//kota harian
			$dataall['REKAP_HARIANREAL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']][$row['KD_AREA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETHARIAN'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']][$row['KD_AREA']]['TARGET'] += $row['TARGETHARIAN'];	
			$dataall['REKAP_HARIANLALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETHARIANALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']]['TARGET'] += $row['TARGETHARIAN'];
		}   
		return $dataall;        
    }
	
	function getTargetDist_Biro($conn,$org,$item,$dateNow,$biro){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
		if($org=='7000'){
			$sqlm = " or VKORG = '5000' ";
		}
        $sqlquery="
            select * from ( 
			select tmnk.*,d.name1  from (
            	select tbmain.*,tbmare.* from ( 
            	select tbtarget.*, nvl(tbreal.realto,0) as realto from( 
            	select tb1.*,tb2.budat,tb2.porsiv,nvl((tb1.TARGET*tb2.PORSIV),0) as TARGETHARIAN from( 
            --target zak 
            	select KUNNR as DIST,MATNR as ITEM_NO,BZIRK as KD_KOTA,sum(QTY) as TARGET from SAP_T_INDEX_DIST_ADJ_SVM where 
				(VKORG = '$org' $sqlm ) and TAHUN = '$thn' 
            	and BULAN = '$bln' and MATNR = '$item'
            	group by KUNNR,MATNR,BZIRK
            	)tb1 left join ( 
            --porsi harian 
            	select c.budat,c.TIPE, SUM(PORSI/total_porsi) as PORSIV from ( 
            	select budat,region,TIPE,PORSI from zreport_porsi_sales_region where vkorg ='$org'  and region=5 and 
            	BUDAT BETWEEN '".$periode."01' and '$dateNow' )c left join( select region, tipe, sum(porsi) as total_porsi 
            	from zreport_porsi_sales_region where budat like '".$periode."%' and region=5 and vkorg ='$org' group by region, tipe )d 
            	on(c.TIPE=d.TIPE and c.REGION=d.REGION) group by c.budat,c.TIPE )tb2 on(tb2.TIPE=tb1.ITEM_NO) )tbtarget left join ( 
            -- realisai 
            	select substr(sold_to,-3) as DIST,kota,substr(item_no,0,7) as item_no, to_char(tgl_cmplt,'yyyymmdd') as budat, sum(kwantumx) as realto
            		from zreport_rpt_real 
            		where 
            		to_char(tgl_cmplt,'YYYYMMDD') between '".$periode."01' and '$dateNow' 
            		and ( (order_type <>'ZNL' and 
            		(item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%' 
            		and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and no_polisi <> 'S11LO' 
            		and sold_to like '0000000%' 
            		AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')
            		group by prov) 
					group by sold_to,kota,substr(item_no,0,7),to_char(tgl_cmplt,'yyyymmdd')
            	)tbreal 
            	on (tbtarget.DIST=tbreal.DIST and tbtarget.kd_kota=tbreal.kota and tbtarget.item_no=tbreal.item_no and tbtarget.budat=tbreal.budat) )tbmain 
                left join ( 
            		select tbkota.*,tbprop.nm_prov,tbprop.nm_prov_1,tbprop.urut,tbprop.biro_sco from ( 
            		select tbkt.*,tbare.desch,tbare.no_area,tbare.desc_area from( 
            		select kd_prop,kd_kota as kdkota,nm_kota,KD_AREA from ZREPORT_M_KOTA )tbkt left join ( 
            		select kd_area,desch,no_area,desc_area from ZREPORT_M_AREA )tbare on (tbkt.KD_AREA=tbare.kd_area) )tbkota 
            		left join ZREPORT_M_PROVINSI tbprop on(tbkota.kd_prop=tbprop.kd_prov) )tbmare 
            on(tbmain.kd_kota=tbmare.kdkota)
			)tmnk left join M_CUSTOMER d on (to_number(tmnk.dist)=to_number(d.kunnr))
			) 
            order by DIST,budat,KD_KOTA asc 
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['REKAP_AREALALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['TARGET'] += $row['TARGETHARIAN'];
			$dataall['REKAP_AREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKAP_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKPDETAIL_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['BUDAT']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKPDETAIL_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['BUDAT']][$row['KD_KOTA']]['TARGET'] += $row['TARGETHARIAN'];	 
			$dataall['REKP_KOTA'][$row['KD_KOTA']]= $row['NM_KOTA'];	 
			$dataall['REKP_PROP'][$row['KD_KOTA']]= $row['NM_PROV'];	 
			$dataall['REKP_AREA'][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREABIRO'][$row['BIRO_SCO']][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREAKOTA'][$row['KD_AREA']][$row['KD_KOTA']]= $row['KD_KOTA'];
            
            //dist
            $dataall['REKAP_DISTAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['DIST']]['REAL'] += $row['REALTO'];	
            $dataall['REKAP_DISTTARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['DIST']]['TARGET'] += $row['TARGETHARIAN'];
            $dataall['REKP_AREADIST'][$row['KD_AREA']][$row['DIST']]= $row['DIST'];
            $dataall['REKP_DIST'][$row['DIST']]= $row['NAME1'];	 
			
			//dist harian
			$dataall['REKAP_DISTALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']][$row['DIST']]['REAL'] += $row['REALTO'];	
            $dataall['REKAP_DISTTARGETALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']][$row['DIST']]['TARGET'] += $row['TARGETHARIAN'];
			$dataall['REKAP_DISTHARAINALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];
			$dataall['REKAP_TARGETHARIANALL'][$row['BIRO_SCO']][$row['BUDAT']][$row['ITEM_NO']]['TARGET'] += $row['TARGETHARIAN'];
			
		}   
		return $dataall;        
    }
	
	function getTarget_BiroBulanan($conn,$org,$item,$dateNow,$biro){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
		if($org=='7000'){
			$sqlm = " or substr(KD_PLANT,0,1) = substr('5',0,1)  ";
		}
        $sqlquery="
        select * from (
		select tbmain.*,tbmare.* from (
		select tbtarget.*, nvl(tbreal.realto,0) as realto from(
		--target zak
		SELECT kd_kota,ITEM_NO,sum(target) as targetb from ZREPORT_TARGET_PLANT WHERE (substr(KD_PLANT,0,1) = substr('$org',0,1) $sqlm)
		and TAHUN = '$thn' and  BULAN = '$bln' and ITEM_NO = '$item' and BRAN12 is null and KODE_DA is null
		group by kd_kota,ITEM_NO
		)tbtarget left join (
			-- realisai
			select kota,substr(item_no,0,7) as item_no,sum(kwantumx) as realto
			from zreport_rpt_real 
			where         
			to_char(tgl_cmplt,'YYYYMMDD') between '".$periode."01' and '$dateNow'
			and ( (order_type <>'ZNL' and
			(item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
			and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and no_polisi <> 'S11LO'
			and sold_to like '0000000%' 
			AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')group by prov)
			group by kota,substr(item_no,0,7)
		)tbreal on (tbtarget.kd_kota=tbreal.kota and tbtarget.item_no=tbreal.item_no)
		)tbmain left join (
			select tbkota.*,tbprop.nm_prov,tbprop.nm_prov_1,tbprop.urut,tbprop.biro_sco from (
				select tbkt.*,tbare.desch,tbare.no_area,tbare.desc_area from(
					select kd_prop,kd_kota as kdkota,nm_kota,KD_AREA from ZREPORT_M_KOTA
				)tbkt left join (
					select kd_area,desch,no_area,desc_area from ZREPORT_M_AREA
				)tbare on (tbkt.KD_AREA=tbare.kd_area)
			)tbkota left join ZREPORT_M_PROVINSI tbprop on(tbkota.kd_prop=tbprop.kd_prov)
		)tbmare on(tbmain.kd_kota=tbmare.kdkota)
		)
		order by no_area,kd_kota asc
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['REKAP_AREALALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['TARGET'] += $row['TARGETB'];
			$dataall['REKAP_AREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['TARGET'] += $row['TARGETB'];	 
			$dataall['REKAP_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['TARGET'] += $row['TARGETB'];	
			$dataall['REKP_KOTA'][$row['KD_KOTA']]= $row['NM_KOTA'];	 
			$dataall['REKP_PROP'][$row['KD_KOTA']]= $row['NM_PROV'];	 
			$dataall['REKP_AREA'][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREABIRO'][$row['BIRO_SCO']][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREAKOTA'][$row['KD_AREA']][$row['KD_KOTA']]= $row['KD_KOTA'];	 

		}   
		return $dataall;        
    }
	
	function getTargetDist_BiroBulanan($conn,$org,$item,$dateNow,$biro){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
		if($org=='7000'){
			$sqlm = " or VKORG = '5000' ";
		}
        $sqlquery="			
			select * from ( 
			select tmnk.*,d.name1  from (
				select tbmain.*,tbmare.* from ( 
				select tbtarget.*, nvl(tbreal.realto,0) as realto from( 
			--target zak 
				select KUNNR as DIST,MATNR as ITEM_NO,BZIRK as KD_KOTA,sum(QTY) as TARGETB from SAP_T_INDEX_DIST_ADJ_SVM where 
				(VKORG ='$org' $sqlm) and TAHUN = '$thn' 
            	and BULAN = '$bln' and MATNR = '$item'
				group by KUNNR,MATNR,BZIRK
				)tbtarget left join ( 
			-- realisai 
					select substr(sold_to,-3) as DIST,kota,substr(item_no,0,7) as item_no, sum(kwantumx) as realto
					from zreport_rpt_real 
					where 
					to_char(tgl_cmplt,'YYYYMMDD') between '".$periode."01' and '$dateNow' 
					and ( (order_type <>'ZNL' and 
					(item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%' 
					and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and no_polisi <> 'S11LO' 
					and sold_to like '0000000%' 
					AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')
					group by prov) 
					group by sold_to,kota,substr(item_no,0,7)
				)tbreal 
				on (tbtarget.DIST=tbreal.DIST and tbtarget.kd_kota=tbreal.kota and tbtarget.item_no=tbreal.item_no ) 
				
				)tbmain 
				left join ( 
					select tbkota.*,tbprop.nm_prov,tbprop.nm_prov_1,tbprop.urut,tbprop.biro_sco from ( 
					select tbkt.*,tbare.desch,tbare.no_area,tbare.desc_area from( 
					select kd_prop,kd_kota as kdkota,nm_kota,KD_AREA from ZREPORT_M_KOTA )tbkt left join ( 
					select kd_area,desch,no_area,desc_area from ZREPORT_M_AREA )tbare on (tbkt.KD_AREA=tbare.kd_area) )tbkota 
					left join ZREPORT_M_PROVINSI tbprop on(tbkota.kd_prop=tbprop.kd_prov) )tbmare 
			on(tbmain.kd_kota=tbmare.kdkota)
			)tmnk left join M_CUSTOMER d on (to_number(tmnk.dist)=to_number(d.kunnr))
			) 
			order by DIST,KD_KOTA asc 
			
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['REKAP_AREALALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGETALL'][$row['BIRO_SCO']][$row['ITEM_NO']]['TARGET'] += $row['TARGETB'];
			$dataall['REKAP_AREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_TARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']]['TARGET'] += $row['TARGETB'];	 
			$dataall['REKAP_KOTAAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['REAL'] += $row['REALTO'];	 
			$dataall['REKAP_KOTATARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['KD_KOTA']]['TARGET'] += $row['TARGETB'];	 
			$dataall['REKP_KOTA'][$row['KD_KOTA']]= $row['NM_KOTA'];	 
			$dataall['REKP_PROP'][$row['KD_KOTA']]= $row['NM_PROV'];	 
			$dataall['REKP_AREA'][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREABIRO'][$row['BIRO_SCO']][$row['KD_AREA']]= $row['DESCH'];	 
			$dataall['REKP_AREAKOTA'][$row['KD_AREA']][$row['KD_KOTA']]= $row['KD_KOTA'];
            
            //dist
            $dataall['REKAP_DISTAREAL'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['DIST']]['REAL'] += $row['REALTO'];	
            $dataall['REKAP_DISTTARGET'][$row['BIRO_SCO']][$row['ITEM_NO']][$row['KD_AREA']][$row['DIST']]['TARGET'] += $row['TARGETB'];
            $dataall['REKP_AREADIST'][$row['KD_AREA']][$row['DIST']]= $row['DIST'];
            $dataall['REKP_DIST'][$row['DIST']]= $row['NAME1'];	 
			
			
		}   
		return $dataall;        
    }
	
	function getSisoSODist_Biro($conn,$org,$item,$dateNow,$biro){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
        $sqlquery="
		select tbmain.*,tbmare.* from ( 
            SELECT NMORG AS ORG, DISTRIK AS KD_KOTA,substr(SOLD_TO_CODE,-3) as SOLD_TO_CODE, SUM(SISA_TO) as sisa_so
			FROM ZREPORT_SO_BUFFER so 
			JOIN ZREPORT_M_KOTA mkota on ( so.DISTRIK = MKOTA.KD_KOTA)
			WHERE so.NMORG in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin)
			and so.ITEM_NO LIKE '$item%'
			AND ITEM_NO not IN (select item_no from ZREPORT_EXCLUDE_ITEM where delete_mark=0) 
			and so.SISA_TO >= 25 
			and so.SOLD_TO_CODE not in (select kd_proyek from ZREPORT_EXCLUDE_SOLDTO where delete_mark=0 and org in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin))
			group by NMORG, DISTRIK,SOLD_TO_CODE
			)tbmain left join ( 
				select tbkota.*,tbprop.nm_prov,tbprop.nm_prov_1,tbprop.urut,tbprop.biro_sco from ( 
				select tbkt.*,tbare.desch,tbare.no_area,tbare.desc_area from( 
				select kd_prop,kd_kota as kdkota,nm_kota,KD_AREA from ZREPORT_M_KOTA )tbkt left join ( 
				select kd_area,desch,no_area,desc_area from ZREPORT_M_AREA )tbare on (tbkt.KD_AREA=tbare.kd_area) )tbkota 
				left join ZREPORT_M_PROVINSI tbprop on(tbkota.kd_prop=tbprop.kd_prov) )tbmare 
		on(tbmain.kd_kota=tbmare.kdkota)
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['REPORT_SISASOBIRO'][$row['BIRO_SCO']][$row['KD_AREA']][$row['SOLD_TO_CODE']] += $row['SISA_SO'];	 
			$dataall['REPORT_SISASOALL'][$row['BIRO_SCO']] += $row['SISA_SO'];	 
			$dataall['REPORT_SISASODISTALL'][$row['BIRO_SCO']][$row['SOLD_TO_CODE']] += $row['SISA_SO'];	 
			$dataall['REPORT_SISASOAREALL'][$row['BIRO_SCO']][$row['KD_AREA']] += $row['SISA_SO'];	 

		}   
		return $dataall;        
    }
	
	function getporsi_harian($conn,$org,$dateNow){
        unset($dataall);
		$thn = substr($dateNow,0,4);
		$bln = substr($dateNow,4,2);
		$tgl = sprintf("%02d", substr($dateNow,6,2));
		$periode=$thn.$bln;
        $sqlquery="
		--porsi harian
		select c.budat,c.TIPE, SUM(PORSI/total_porsi) as PORSIV from (
			select budat,region,TIPE,PORSI from zreport_porsi_sales_region
			where vkorg = '$org' and region=5
			and BUDAT BETWEEN '".$periode."01' and '$dateNow'
		)c left join(
			select region, tipe, sum(porsi) as total_porsi 
			from zreport_porsi_sales_region 
			where budat like '$periode%' and region=5 and vkorg ='$org' group by region, tipe 
		)d on(c.TIPE=d.TIPE and c.REGION=d.REGION)
		group by c.budat,c.TIPE
        ";
        
        $excquery= oci_parse($conn, $sqlquery);        
        oci_execute($excquery);		
		while($row=oci_fetch_array($excquery)){            
			$dataall['PORSIH_ITEM'][$row['BUDAT']][$row['TIPE']] += $row['PORSIV'];	 
			$dataall['PORSIALL_ITEM'][$row['BUDAT']] += $row['PORSIV'];	 
			$dataall['PORSIH_ALLL'][$row['BUDAT']] += $row['PORSIV'];
			$dataall['PORSI_ITEMALL'][$row['TIPE']] += $row['PORSIV'];	 
			$dataall['PORSI_ALL'] += $row['PORSIV'];	 
				 

		}   
		return $dataall;        
    }
    
    public function getRealisasiKumST($connm,$org,$datekemarin){
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));

		$zakcode='121-301';
		$curcode='121-302';	
		$queryTot= "	
		select tb3.*,tb4.nm_region from(
		select propinsi_to,nm_prov_1,id_region,budat,typem,sum(real) as realto from (
		select tb1.*,tb2.id_region,tb2.nm_prov_1 from (
                select com,propinsi_to, budat, typem, sum(real) as real from(
                    select com,propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as budat, substr(item_no,0,7) as typem, sum(kwantumx) as real
                    from zreport_rpt_real_st 
                    where         
                    to_char(tgl_cmplt,'YYYYMMDD') = '$datekemarin'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and com = '$org' and no_polisi <> 'S11LO'
                    and sold_to like '000000%' 
                    and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$org' and TIPE in ('ICS', 'PAKAI_SENDIRI') AND DELETE_MARK = '0' GROUP BY SOLD_TO)
                    --and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$org' and TIPE =  AND DELETE_MARK = '0' GROUP BY SOLD_TO) --Pemakaian Sendiri
                    and ORDER_TYPE<>'ZLFE'
                    group by com,propinsi_to,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                    --ekspor
                    union
                    select com,'0001' as propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as budat, substr(item_no,0,7) as typem, sum(kwantumx) as real
                    from zreport_rpt_real_st 
                    where         
                    to_char(tgl_cmplt,'YYYYMMDD') = '$datekemarin'
                    and com = '$org'
                    and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$org' and TIPE = 'PAKAI_SENDIRI' AND DELETE_MARK = '0' GROUP BY SOLD_TO) --Pemakaian Sendiri
                    and ORDER_TYPE='ZLFE'
                    group by com,propinsi_to,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                    union
                    select ti.COM,ti.propinsi_to, to_char(tgl_cmplt,'YYYYMMDD') as budat,substr(item_no,0,7) as typem,sum(ti.KWANTUMX) as real 
                    from ZREPORT_RPT_REAL_NON70_ST ti 
                    where (ti.ITEM_NO LIKE '121-301%' or ti.ITEM_NO LIKE '121-302%')
                    and item_no <> '121-301-0240'
                        and to_char(tgl_cmplt,'YYYYMMDD') = '$datekemarin'
                    and ti.COM='$org'
                    and ti.ROUTE='ZR0001'
                    and ti.STATUS in ('50')
                    and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='$org')
                    group by ti.COM,ti.propinsi_to,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                   --realisasi return
                    union
                    select VKORG as com,vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as budat, substr(matnr,0,7) as typem, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                    where VKORG ='4000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='$datekemarin'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                    and kunag like '0000000%'
                    and kunnr not like '000000%'
                    and kunag not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$org' and TIPE in ('ICS', 'PAKAI_SENDIRI') AND DELETE_MARK = '0' GROUP BY SOLD_TO)
                    group by VKORG,vkbur,substr(matnr,0,7),to_char(wadat_ist,'YYYYMMDD')
                    )group by COM,propinsi_to,typem,budat
                )tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.propinsi_to=tb2.kd_prov)
                                )
                                group by propinsi_to,nm_prov_1,id_region,budat,typem
                                )tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
                                order by tb3.propinsi_to,tb3.id_region,budat,typem
		
		";
		$queryTot= oci_parse($connm, $queryTot);
		$sukses_query = oci_execute($queryTot);
		$dataall['REKAP_REGION']=array();
		$dataall['REKAP_PROV'] =array();
		$dataall['REKAP_TOTREGION']=array();
		$dataall['REKAP_BUDATZAK']=array();
		$dataall['REKAP_BUDATTO']=array();
		$dataall['M_REGION']=array();
		$dataall['M_PROV']=array();

		while ($dataTot = oci_fetch_array($queryTot)) {
			echo '<pre>';
			print_r($dataTot);
			echo '</pre>';
			$dataall['REKAP_REGION'][$dataTot['BUDAT']][$dataTot['ID_REGION']][$dataTot['TYPEM']] += $dataTot['REALTO'];        
			// $dataall['REKAP_PROV'][$dataTot['PROPINSI_TO']][$dataTot['TYPEM']] += $dataTot['REALTO'];        
			// $dataall['REKAP_TOTREGION'][$dataTot['ID_REGION']][$dataTot['TYPEM']] += $dataTot['REALTO'];        
			// if($dataTot['TYPEM']==$zakcode){
			// 	$dataall['REKAP_BUDATZAK'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			// }else{
			// 	$dataall['REKAP_BUDATTO'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			// }
			// $dataall['M_REGION'][$dataTot['ID_REGION']]=$dataTot['NM_REGION'];
			// $dataall['M_PROV'][$dataTot['PROPINSI_TO']]=$dataTot['NM_PROV_1'];
		}
		
		return $dataall;
	}
	
        function getLaporanPlantST($connm,$com,$dayKemarin){
		unset($dataall);
		$datenowf=date("Ymd");
		$formdatmkll=date("Ymd", strtotime("$datenowf -31 days"));
		$todatmkll=date("Ymd", strtotime("$datenowf +31 days"));
		$sqlplant="select tb1.*,tb2.name from (
                select com,plant, budat, typem, sum(real) as real from(
                    select com,plant, to_char(tgl_cmplt,'YYYYMMDD') as budat, substr(item_no,0,7) as typem, sum(kwantumx) as real
                    from zreport_rpt_real_st 
                    where         
                    to_char(tgl_cmplt,'YYYYMMDD') = '$dayKemarin'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and com = '$com' and no_polisi <> 'S11LO'
                    and sold_to like '000000%' 
                    and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$com' and TIPE in ('ICS', 'PAKAI_SENDIRI') AND DELETE_MARK = '0' GROUP BY SOLD_TO)--'0000040084','0000040147','0000040272','0000000888','0000000945')
                    --and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$com' and TIPE =  AND DELETE_MARK = '0' GROUP BY SOLD_TO)--'0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    and ORDER_TYPE<>'ZLFE'
                    group by com,plant,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                    --ekspor
                    union
                    select com,'0001' as plant, to_char(tgl_cmplt,'YYYYMMDD') as budat, substr(item_no,0,7) as typem, sum(kwantumx) as real
                    from zreport_rpt_real_st 
                    where         
                    to_char(tgl_cmplt,'YYYYMMDD') = '$dayKemarin'
                    and com = '$com'
                    and SOLD_TO not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$com' and TIPE = 'PAKAI_SENDIRI' AND DELETE_MARK = '0' GROUP BY SOLD_TO)--'0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    and ORDER_TYPE='ZLFE'
                    group by com,plant,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                    union
                    select ti.COM,ti.plant, to_char(tgl_cmplt,'YYYYMMDD') as budat,substr(item_no,0,7) as typem,sum(ti.KWANTUMX) as real 
                    from ZREPORT_RPT_REAL_NON70_ST ti 
                    where (ti.ITEM_NO LIKE '121-301%' or ti.ITEM_NO LIKE '121-302%')
                    and item_no <> '121-301-0240'
                        and to_char(tgl_cmplt,'YYYYMMDD') = '$dayKemarin'
                    and ti.COM='$com'
                    and ti.ROUTE='ZR0001'
                    and ti.STATUS in ('50')
                    and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='$com')
                    group by ti.COM,ti.plant,substr(item_no,0,7),to_char(tgl_cmplt,'YYYYMMDD')
                --realisasi return
                    union
                    select VKORG as com,vkbur as propinsi_to, to_char(wadat_ist,'YYYYMMDD') as budat, substr(matnr,0,7) as typem, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD 
                    where VKORG ='4000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='$datekemarin'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                    and kunag like '0000000%'
                    and kunnr not like '000000%'
                    and kunag not in (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS WHERE ORG = '$org' and TIPE in ('ICS', 'PAKAI_SENDIRI') AND DELETE_MARK = '0' GROUP BY SOLD_TO)
                    group by VKORG,vkbur,substr(matnr,0,7),to_char(wadat_ist,'YYYYMMDD')
                    )group by COM,plant,typem,budat)tb1 left join ZREPORT_M_PLANT tb2 on(tb1.plant=tb2.kd_plant)
		";    
		$queryplant= oci_parse($connm, $sqlplant);
		oci_execute($queryplant);		
		while($row=oci_fetch_array($queryplant)){            
			$dataall['DATA_PLANT'][$row['PLANT']][$row['TYPEM']]+=$row['REAL'];
                        $dataall['NAMA_PLANT'][$row['PLANT']]=$row['NAME'];
		}   
		return $dataall;
	}
    
    function getLaporanPlantSP($connm,$com,$dayKemarin){
		unset($dataall);
		$datenowf=date("Ymd");
		$formdatmkll=date("Ymd", strtotime("$datenowf -31 days"));
		$todatmkll=date("Ymd", strtotime("$datenowf +31 days"));
		$sqlplant="select tb3.* from(
		select PLANT,NAME,budat,item_no,sum(target_real) as realto from (

		select tb1.*,tb2.name from (
		select WERKS as PLANT,to_char(wadat_ist,'yyyymmdd')as budat, sum(ton) as target_real, 
    substr(matnr,0,7) as item_no
		from zreport_ongkosangkut_mod 
		where         
		to_char(wadat_ist,'YYYYMMDD') = '$dayKemarin'
		and ( (lfart <>'ZNL' and
		(matnr like '121-301%' and matnr <> '121-301-0240')) or (matnr like '121-302%'
		and lfart <>'ZNL') or (matnr like '121-200%' and  WERKS='0001') ) 
		and kunag not in 
    (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS where ORG = '$com' and 
	   TIPE in('ICS','PAKAI_SENDIRI') and DELETE_MARK = 0 ) and vkorg = '$com'
        --and werks not in('3606','3607','3616','3628','3631','3625')  
		group by WERKS,to_char(wadat_ist,'yyyymmdd') ,substr(matnr,0,7)
		order by PLANT,budat
		)tb1 left join ZREPORT_M_PLANT tb2 on(tb1.PLANT=tb2.kd_plant)

		)
		group by PLANT,NAME,budat,item_no
		)tb3 
		order by tb3.PLANT,budat,item_no
		";    
		$queryplant= oci_parse($connm, $sqlplant);
		oci_execute($queryplant);		
		while($row=oci_fetch_array($queryplant)){            
			$dataall['DATA_PLANT'][$row['PLANT']][$row['ITEM_NO']]+=$row['REALTO'];
                        $dataall['NAMA_PLANT'][$row['PLANT']]=$row['NAME'];
		}   
		return $dataall;
	}
    
    
    function getRealisasiKumSP($connm,$org,$datekemarin){
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$zakcode='121-301';
		$curcode='121-302';	
		$queryTot= "	
		select tb3.*,tb4.nm_region from(
		select prov,nm_prov_1,id_region,budat,item_no,sum(target_real) as realto from (

		select tb1.*,tb2.id_region,tb2.nm_prov_1 from (
		select VKBUR as prov,to_char(wadat_ist,'yyyymmdd')as budat, sum(ton) as target_real, 
    substr(matnr,0,7) as item_no
		from zreport_ongkosangkut_mod 
		where         
		to_char(wadat_ist,'YYYYMMDD') = '$datekemarin' and vkbur <>'0001'
		and ( (lfart <>'ZNL' and
		(matnr like '121-301%' and matnr <> '121-301-0240')) or (matnr like '121-302%'
		and lfart <>'ZNL') or (matnr like '121-200%' and  vkbur='0001') ) 
		and kunag not in 
    (select SOLD_TO from ZREPORT_CUSTOMER_KHUSUS where ORG = '$org' and 
	   TIPE in('ICS','PAKAI_SENDIRI') and DELETE_MARK = 0 ) and vkorg = '$org'
        --and werks not in('3606','3607','3616','3628','3631','3625')  
		group by vkbur,to_char(wadat_ist,'yyyymmdd') ,substr(matnr,0,7)
		order by prov,budat
		)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)

		)
		group by prov,nm_prov_1,id_region,budat,item_no
		)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
		order by tb3.prov,tb3.id_region,budat,item_no
		
		";
		$queryTot= oci_parse($connm, $queryTot);
		$sukses_query = oci_execute($queryTot);
		while ($dataTot = oci_fetch_array($queryTot)) {
			$dataall['REKAP_REGION'][$dataTot['BUDAT']][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_PROV'][$dataTot['PROV']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_TOTREGION'][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];       
			if($dataTot['ITEM_NO']==$zakcode){
				$dataall['REKAP_BUDATZAK'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}else{
				$dataall['REKAP_BUDATTO'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}
			$dataall['M_REGION'][$dataTot['ID_REGION']]=$dataTot['NM_REGION'];
			$dataall['M_PROV'][$dataTot['PROV']]=$dataTot['NM_PROV_1'];
		}
		
		return $dataall;
	}
    
    function getRealisasiKumSGRembang($connm,$org,$datekemarin,$customer){
		unset($dataall);
		$thn = substr($datekemarin,0,4);
		$bln = substr($datekemarin,4,2);
		$tgl = sprintf("%02d", substr($datekemarin,6,2));
		$zakcode='121-301';
		$curcode='121-302';
        $klicode='121-200';		
        $cust   = $customer;
		$queryTot= "	
		select tb3.*,tb4.nm_region from(
		select prov,nm_prov_1,id_region,budat,item_no,sum(target_real) as realto from (
		select tb1.*,tb2.id_region,tb2.nm_prov_1 from (
		select propinsi_to as prov,to_char(tgl_cmplt,'yyyymmdd')as budat, sum(kwantumx) as target_real, substr(item_no,0,7) as item_no
		from zreport_rpt_real 
		where         
		to_char(tgl_cmplt,'YYYYMMDD') between '".$thn.$bln."01' and '$datekemarin'
		and ( (order_type <>'ZNL' and
		(item_no like '121-301%' or item_no like '121-200%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
		and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') 
		and com ='$org' and no_polisi <> 'S11LO'
		and sold_to like '$cust%' 
		AND propinsi_to in (select prov from SAP_T_RENCANA_SALES_TYPE where co in (select orgin from ZREPORT_M_INCOM where orgm='$org' and delete_mark=0 group by orgin) and thn='$thn' and bln='$bln' and prov not in('1092','0001')group by prov)
		group by propinsi_to,to_char(tgl_cmplt,'yyyymmdd') ,substr(item_no,0,7)
		order by PROV,budat
		)tb1 left join ZREPORT_M_PROVINSI tb2 on(tb1.prov=tb2.kd_prov)
		)
		group by prov,nm_prov_1,id_region,budat,item_no
		)tb3 left join ZREPORT_M_REGION tb4 on(tb3.id_region=tb4.id_region)
		order by tb3.prov,tb3.id_region,budat,item_no
		
		";
		$queryTot= oci_parse($connm, $queryTot);
		$sukses_query = oci_execute($queryTot);
		while ($dataTot = oci_fetch_array($queryTot)) {
			$dataall['REKAP_REGION'][$dataTot['BUDAT']][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_REALTGLPROV'][$dataTot['BUDAT']][$dataTot['PROV']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_PROV'][$dataTot['PROV']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			$dataall['REKAP_TOTREGION'][$dataTot['ID_REGION']][$dataTot['ITEM_NO']] += $dataTot['REALTO'];        
			if($dataTot['ITEM_NO']==$zakcode){
				$dataall['REKAP_BUDATZAK'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}else if($dataTot['ITEM_NO']==$curcode){
				$dataall['REKAP_BUDATTO'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}else{
				$dataall['REKAP_BUDATKLINKER'][$dataTot['BUDAT']] +=$dataTot['REALTO'];
			}
			$dataall['M_REGION'][$dataTot['ID_REGION']]=$dataTot['NM_REGION'];
			$dataall['M_PROV'][$dataTot['PROV']]=$dataTot['NM_PROV_1'];
		}
		
		return $dataall;
	}
	
}

?>