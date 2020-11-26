<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

//$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = dev-sggdata3.sggrp.com)(PORT = 1521))
//        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = devsgg)))';
//$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))
//        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = devsgg)))';
//$username = 'DEVSD';
//$password = 'gresik45';

// $tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.144)(PORT = 1521))
//         (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = pdbsi)))';
// $username = 'APPBISD';
// $password = 'gresik45smigone1';


$db['oramso']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.15.5.122)(PORT=1521))(CONNECT_DATA=(SID=pmdb)))';
//$db['default']['hostname'] = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.15.5.76)(PORT=1521))(CONNECT_DATA=(SID=CMSDB)))';
$db['oramso']['username'] = 'mso';
$db['oramso']['password'] = 's3mengres1k';
$db['oramso']['database'] = '';
$db['oramso']['dbdriver'] = 'oci8';
$db['oramso']['dbprefix'] = '';
$db['oramso']['pconnect'] = TRUE;
$db['oramso']['db_debug'] = TRUE;
$db['oramso']['cache_on'] = FALSE;
$db['oramso']['cachedir'] = '';
$db['oramso']['char_set'] = 'utf8';
$db['oramso']['dbcollat'] = 'utf8_general_ci';
$db['oramso']['swap_pre'] = '';
$db['oramso']['autoinit'] = TRUE;
$db['oramso']['stricton'] = FALSE;


//$tnsname2 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = cmsdb.sggrp.com)(PORT = 1521))
//        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = cmsdb)))';
$tnsname2 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.76)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = cmsdb)))';
$username2 = 'APPSGG';
$password2 = 'sgmerdeka99';

$db['scmproduction'] = array(
        'dsn'   => '',
        'hostname' => $tnsname2,
	'username' => $username2,
	'password' => $password2,
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$tnsname3 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = sggdata3.semenindonesia.com)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = sgg)))';
$username3 = 'marketplace';
$password3 = 's3m3ngres1k';

$db['marketplace'] = array(
        'dsn'   => '',
        'hostname' => $tnsname3,
	'username' => $username3,
	'password' => $password3,
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$tnsname4 = '10.15.3.67';
$username4 = 'user_hmr';
$password4 = '_R34+ch.Th:ePe4k';
$db['hris'] = array(
        'dsn'   => '',
        'hostname' => $tnsname4,
	'username' => $username4,
	'password' => $password4,
	'database' => 'hris',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$tnsname5 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = sgg)))';
$username5 = 'crmnew';
$password5 = 'crm2017321';

$db['crm'] = array(
        'dsn'   => '',
        'hostname' => $tnsname5,
	'username' => $username5,
	'password' => $password5,
	'database' => 'CRMMOBILE',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


//==========================================INI UNTUK SETTING DATABASE PORT MANAGEMENT 
$tnsprod = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.15.5.96)(PORT=1521))(CONNECT_DATA=(SID=sgg)))';

$db['PMS'] = array(
	'dsn' =>'',
	
	// 'hostname' => $tnsname4,
	// 'username' => 'LOCAL_PMS',
	// 'password' => 'admin',
	/*
	'hostname' => $tnsname3,
	'username' => 'management',
	'password' => 'Management16',
	*/
	
	'hostname' => $tnsprod,
	'username' => 'management',
	'password' => 'M4n4g3ment16',
	

	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

//====================================================================================//CRM
$tns_crm = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))
       (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = devsgg)))';
$username_crm = 'crmmobile';
$password_crm = 'si51plus';


 // $tns_crm = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))
         // (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = sgg)))';
 // $username_crm = 'crmnew';
 // $password_crm = 'crm2017321';
  
$db['default'] = array(
    'dsn'   => '',
    'hostname' => $tns_crm,
	'username' => $username_crm,
	'password' => $password_crm,
	'database' => 'CRMMOBILE',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,

	'failover' => array(),
	'save_queries' => TRUE
);


//=============================================================================================

$tnsnamepoinprod = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=sggdata3.semenindonesia.com)(PORT=1521))(CONNECT_DATA=(SID=SGG)))';


$db['Point'] = array(
	 'dsn' =>'',
	 'hostname' => $tnsnamepoinprod,
	 'username' => 'point',
	 'password' => 's3m3ngres1k',
// //
// 	'dsn' =>'',
// 	'hostname' => $tnsnamepoindev,
// 	'username' => 'poin',
// 	'password' => 'Semengresik1',
	
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	//'db_debug' => FALSE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

//=============================================================================================================scmproduction

$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.144)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = pdbsi)))';
$username = 'APPBISD';
$password = 'gresik45smigone1';


$db['SCM'] = array(
	'dsn'	=> '',
	'hostname' => $tnsname,
	'username' => $username,
	'password' => $password,
	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);



//================================================================================================= 3PL Production
$tnd_prod_3pl='(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=sggdata3.semenindonesia.com)(PORT=1521))(CONNECT_DATA=(SID=SGG)))';

$db['3pl'] = array(
	/*
	'dsn' =>'',
	'hostname' => $tns_dev_3pl,
	'username' => 'marketplace',
	'password' => 'semengres1k',
	*/
	'hostname' => $tnd_prod_3pl,
	'username' => 'marketplace',
	'password' => 's3m3ngres1k',

	'database' => '',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

