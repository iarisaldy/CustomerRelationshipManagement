<?
/* Class connected to engine SAP */
@require_once('sgg/include/sapclasses/a.php');
class SAPDataModule_Connection
{        
        private $_konsap;        
        private $_koneksi_sistem;
        
        /* MySQL EIS */
        private $_mysql_host_eis = "10.15.5.71";
        private $_mysql_user_eis = "sgg";
        private $_mysql_pasw_eis = "sggroup";
        private $_mysql_db_eis = "eis";   
        
        /* MySQL EIS */
        private $_mysql_host_bb = "10.100.2.122";
        private $_mysql_user_bb = "admin";
        private $_mysql_pasw_bb = "4dmin";
        private $_mysql_db_bb = "sgflat";   
        
        /* User Dev Oracle */
        private $_ora_user_dev = "dev";
        private $_ora_pasw_dev = "semeru2";
        private $_ora_db_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.150)(PORT = 1521))) (CONNECT_DATA = (SID = XE)(SERVER = DEDICATED)))';
        
        /* User Prod Oracle */
        private $_ora_user_prod = "appsgg";
        private $_ora_pasw_prod = "sgmerdeka99";
        private $_ora_db_prod = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.76)(PORT = 1521))) (CONNECT_DATA = (SID = CMSDB)(SERVER = DEDICATED)))";
        
         /* User PM Dev Oracle */
        private $_ora_user_pm_dev = "qviewadmin";
        private $_ora_pasw_pm_dev = "gadjahmada2011";
        private $_ora_db_pm_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.113)(PORT = 1521))) (CONNECT_DATA = (SID = sggbi)(SERVER = DEDICATED)))';
        
        /* User SD Dev Oracle */
        private $_ora_user_sd_dev = "devsd";
        private $_ora_pasw_sd_dev = "gresik45";
        private $_ora_db_sd_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = dev-sggdata3.sggrp.com)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';
        

        /* SAP Connection to Production */
        public function getConnSAP(){
                $this->_konsap = new SAPConnection();
                /* NB: Ini File Koneksinya */
                $loginFile = 'sgg/include/connect/sap_sd_210.php';
                $this->_konsap->Connect($loginFile);
                if ($this->_konsap->GetStatus() == SAPRFC_OK ) $this->_konsap->Open ();
                if ($this->_konsap->GetStatus() != SAPRFC_OK ) {
                   $this->_konsap->PrintStatus();
                   exit;
                }else {
                        return $this->_konsap;
                }
        }
        
        /* SAP Connection to Dev */
        public function getConnSAP_Dev(){
                $this->_konsap = new SAPConnection();
                /* NB: Ini File Koneksinya */
                $loginFile = '/opt/lampp/htdocs/sgg/include/connect/sap_sd_030.php';
                $this->_konsap->Connect($loginFile);
                if ($this->_konsap->GetStatus() == SAPRFC_OK ) $this->_konsap->Open ();
                if ($this->_konsap->GetStatus() != SAPRFC_OK ) {
                   $this->_konsap->PrintStatus();
                   exit;
                }else {
                        return $this->_konsap;
                }
        }

	/* SAP Connection to Cloning */
        public function getConnSAP_Clon(){
                $this->_konsap = new SAPConnection();
                /* NB: Ini File Koneksinya */
                $loginFile = '/opt/lampp/htdocs/sgg/include/connect/sap_sd_210_clone_sd.php';
                $this->_konsap->Connect($loginFile);
                if ($this->_konsap->GetStatus() == SAPRFC_OK ) $this->_konsap->Open ();
                if ($this->_konsap->GetStatus() != SAPRFC_OK ) {
                   $this->_konsap->PrintStatus();
                   exit;
                }else {
                        return $this->_konsap;
                }
        }

        /* MySQL Connection to Server EIS */
        public function koneksiEIS(){
                $koneksi_eis = $this->getConnMySQL($this->_mysql_host_eis,$this->_mysql_user_eis,$this->_mysql_pasw_eis);
                $koneksidb_eis = $this->getConnDBMySQL($this->_mysql_db_eis,$koneksi_eis);
                return $koneksi_eis;
        }
        
        /* MySQL Connection to Server EIS */
        public function koneksiBB(){
                $koneksi_bb = $this->getConnMySQL($this->_mysql_host_bb,$this->_mysql_user_bb,$this->_mysql_pasw_bb);
                $koneksidb_bb = $this->getConnDBMySQL($this->_mysql_db_bb,$koneksi_bb);
                return $koneksi_bb;
        }
        
        /* Oracle Connection to SDOnline Server */
        public function koneksiSDOnline(){


            if($this->_koneksi_sistem == '') { echo "Client Oracle belum dideklarasi!"; exit; }
            if($this->_koneksi_sistem=='30')
                return $this->getConnOraDB($this->_ora_user_dev, $this->_ora_pasw_dev, $this->_ora_db_dev);
            else if($this->_koneksi_sistem=='31')
                return $this->getConnOraDB($this->_ora_user_sd_dev, $this->_ora_pasw_sd_dev, $this->_ora_db_sd_dev);
            else if($this->_koneksi_sistem=='210')
                return $this->getConnOraDB($this->_ora_user_prod, $this->_ora_pasw_prod, $this->_ora_db_prod);
        }

         public function koneksiPM_Dev(){
                return $this->getConnOraDB($this->_ora_user_pm_dev, $this->_ora_pasw_pm_dev, $this->_ora_db_pm_dev);
        }

         public function koneksiSD_Dev(){
                return $this->getConnOraDB($this->_ora_user_sd_dev, $this->_ora_pasw_sd_dev, $this->_ora_db_sd_dev);
        }
        
        /* Set Oracle Server Client */
        public function setOra_Client($client){
            $this->_koneksi_sistem = $client;
        }
        
        public function koneksiMSSQL_Ciwandan(){
            return $this->getConnMSSQL('SIRILJAS', 'sisfo', 'semengresik', 'paletteDB');
        }
        /*---------------------  Custum method --------------------------------*/
        public function getConnMySQL($ip,$user,$pass){
                $con = @mysql_connect($ip,$user,$pass);
                if (!$con){        die('Koneksi ke Server MySQL Gagal: ' . mysql_error()); }
                return $con;
        }

        public function getConnDBMySQL($database,$connection){
                $condb = @mysql_select_db($database,$connection);
                if(!$condb){ die('Koneksi Database MySQL Gagal: ' . mysql_error()); }
        }
        
        public function getConnOraDB($username,$password,$database){
                $conn = @oci_connect($username, $password, $database );
                if (!$conn)
                        return false;
                else
                 return $conn;
        }
        
        public function getConnMSSQL($tds_name, $username, $password, $database_name){
            $con = mssql_connect($tds_name,$username,$password) or die('Koneksi ke server MSSQL Gagal!');
            mssql_select_db($database_name) or die('Gagal database MSSQL.');
            if($con) return $con; //echo "mantap ting ting";
            else { echo "Koneksi MSSQL Gagal"; }
        }
}
?>