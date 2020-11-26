<?php
session_start();
//=========================================================================================================//
/**
 *
 1. Pengecekan User 
 2. Membaca Request Asset yang diinginkan User
 3. Pengecekan File
 4. Pemberian File pada user.
 */
 //========================================================================================================//
include "../programs/system/master/smi_scurity.php";

if(!empty($_SESSION['SMI'])){

    if(!empty($_GET['rpa'])){//Melihat apakah ada file yang diinginkan user
        $NM_FILE      = $_GET['rpa'];
        $SMI_SCURITY  = new SMI_SCURITY_LOCAL();
        $NM_FILE      = $SMI_SCURITY->DISKRIPSI_VARIABLE($NM_FILE);

        $NM_FILE = "private/". $NM_FILE;
        if(file_exists($NM_FILE)) {//===============================Pengecekan APakah File ada.
            if($NM_FILE=='private/smi.js'){
                $BHS_ENCRIPTION = $SMI_SCURITY->CLient_JSON();
            }
            include $NM_FILE;//File Ditampikan ke user.
        }
        else {
          echo  "SMI SCURITY : File Ajax Tidak Ada";
        }
    }
    else {
        echo "SMI SCURITY : File Tidak Request Assets User yang Ditemukan";
    }
}
else {
    echo "SMI SCURITY : Request Asset Private Tidak dapat diperoses. ";
}
//=========================================================================================================//
?>
