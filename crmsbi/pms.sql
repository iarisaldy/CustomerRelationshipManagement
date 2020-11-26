SELECT 
DT_KAPAL.*
FROM 
	(
		SELECT 
		    DISTINCT(SHIP_NAME) AS SHIP_NAME,
		    NM_PELABUHAN_MUAT
		FROM DT_RENCANA_PKK
		WHERE DELETE_MARK=0
		AND
		     (
		     TO_CHAR(TANGGAL_SELESAI,'YYYYMM') = '201807'
		        OR
		     TO_CHAR(TANGGAL_MULAI,'YYYYMM')  = '201807'
		     )
		AND NM_PELABUHAN_MUAT='PELABUHAN KHUSUS SG DI TUBAN' 
		--AND NM_MUATAN=''
		ORDER BY SHIP_NAME
	) DT_KAPAL
LEFT JOIN SHIP S ON DT_KAPAL.SHIP_NAME=S

#==================================================
SELECT 
				AH.ID AS PKK_ID,
				AH.ACT_TYPE,
                P.ID AS SANDAR_ID,
                KD.KD_NAME AS NAMA_KADE,
                P.PORT_NAME AS PORT_SANDAR,
                P2.ID AS TUJUAN_ID,
                P2.PORT_NAME AS PORT_TUJUAN,
                S.SHIP_CALL_SIGN,
                S.SHIP_NAME,
				C1.ID AS AGEN_ID,
				C1.COMPANY_NAME AS AGEN_NAME,
				C2.ID AS PBM_ID,
				C2.COMPANY_NAME AS PBM_NAME,
                SP.ID AS MUATAN_ID,
				SP.SHIP_PRODUCT_NAME AS NM_MUATAN,
				AH.ACT_CARGO_TOTAL AS TOTAL_MUATAN,
				PBM_H.BL,
				PBM_H.TIMBANGAN,
				PBM_H.DRAFT,
				H_PEMBONGKARAN.JUMLAH AS SUDAH_BM,
				TO_CHAR (AH.ACT_ETA, 'DD-MM-YYYY (HH24:MI)') AS TANGGAL_PKK
			FROM ACT_HEADER AH
            LEFT JOIN PORT P ON AH.ACT_PORT_BERTH=P.ID
            LEFT JOIN PORT_DOCK_KD KD ON AH.ACT_KD=KD.ID
            LEFT JOIN PORT P2 ON AH.ACT_PORT_TO=P2.ID
            LEFT JOIN SHIP S ON AH.SHIP_ID=S.ID
			LEFT JOIN COMPANY C1 ON AH.AGENT_CODE=C1.ID
			LEFT JOIN COMPANY C2 ON AH.ACT_PBM=C2.ID
			LEFT JOIN SHIP_PRODUCT SP ON AH.ACT_CARGO=SP.ID
			LEFT JOIN KPL_ACT_PBM_HDR PBM_H ON AH.ID=PBM_H.ID_PKK
			LEFT JOIN (
									SELECT KH.ID_PKK,
										SUM(KA.JUMLAH) AS JUMLAH
									FROM KPL_ACT_PBM_HDR KH
									LEFT JOIN KPL_ACT_PBM_DTL KA ON KH.ID = KA.PBM_HDR_ID AND KA.DELETE_MARK = 0
									WHERE KH.DELETE_MARK = 0 
									GROUP BY KH.ID_PKK
						) H_PEMBONGKARAN ON AH.ID=H_PEMBONGKARAN.ID_PKK
			WHERE AH.ID='1000004525' AND AH.IS_DELETED=0
#==========================================================================
SELECT
			  TO_CHAR(PBM_D.WAKTU_MULAI, 'DD-MM-YYYY') AS TGL_PEMBONGKARAN,
			  TO_CHAR(PBM_D.WAKTU_MULAI, 'DD-MM-YYYY (HH24:MI)') AS WAKTU_MULAI,
              TO_CHAR(PBM_D.WAKTU_SELESAI, 'DD-MM-YYYY (HH24:MI)') AS WAKTU_SELESAI,
			  PBM_D.STATUS_KERJA,
			  PBM_D.ID_KENDALA,
			  PBM_D.NM_KENDALA,
			  PBM_D.ID_ALAT_BONGKAR,
			  PBM_D.NM_ALAT_BONGKAR,
			  PBM_D.KEGIATAN,
			  PBM_D.SHIFT,
			  NVL(PBM_D.RITASE,0) AS RITASE,
			  NVL(PBM_D.GANG,0) AS GANG,
			  NVL(PBM_D.JUMLAH,0) AS JUMLAH
			FROM 
			  KPL_ACT_PBM_HDR PBM_H
			LEFT JOIN 
			  KPL_ACT_PBM_DTL PBM_D ON PBM_H.ID=PBM_D.PBM_HDR_ID
			WHERE
			  PBM_H.ID_PKK = '$pkk' AND 
			  PBM_H.DELETE_MARK = 0 AND 
			  PBM_D.DELETE_MARK = 0		
			ORDER BY 
			  PBM_D.WAKTU_MULAI ASC

#================================================