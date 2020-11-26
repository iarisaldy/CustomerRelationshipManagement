<?php

class Inc_Koneksi {

    public function koneksi1() {
        $or_username = "dev";
        $or_password = "semeru2";
        $or_db = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.150)(PORT = 1521))) (CONNECT_DATA = (SID = XE)(SERVER = DEDICATED)))';
        $conn = oci_connect($or_username, $or_password, $or_db);
        if (!$conn)
            return false;
        else
            return $conn;
    }

    public function koneksi2() {
        $or_db = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST =dev-sggdata3.sggrp.com)(PORT = 1521)) (CONNECT_DATA= (SID = devsgg) (SERVER = DEDICATED)))'; // session id
        $or_username = 'devsd';
        $or_password = 'gresik45';
        $conn = oci_connect($or_username, $or_password, $or_db);
        if (!$conn)
            return false;
        else
            return $conn;
    }
	
	public function koneksi1Prod() {
        $or_db = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST =10.15.5.76)(PORT = 1521)) (CONNECT_DATA= (SID = CMSDB) (SERVER = DEDICATED)))'; // session id
        $or_username = 'appsgg';
        $or_password = 'sgmerdeka99';
        $conn = oci_connect($or_username, $or_password, $or_db);
        if (!$conn)
            return false;
        else
            return $conn;
    }
	
	public function koneksiSiloTuban() {
        $or_db = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.99.42.100)(PORT = 1521))) (CONNECT_DATA = (SID = XE)(SERVER = DEDICATED)))'; // session id
        $or_username = 'devplg';
        $or_password = 'indonesiamerdeka45';
        $conn = oci_connect($or_username, $or_password, $or_db);
        if (!$conn)
            return false;
        else
            return $conn;
    }

}

?>
