#!/usr/local/bin/php -q
<?
// ----------------------------------------------------------------------------
// SAPRFC - Server example
// PHP server function RFC_READ_REPORT
// Require: CGI version PHP, RFC destination defined in SAP R/3 (SM59)
// http://saprfc.sourceforge.net
// ----------------------------------------------------------------------------

// Interface definiton for RFC_READ_REPORT
// (generated by saprfc.php - option Generate PHP)

   $DEF_RFC_READ_REPORT = array (
  			 array (
  				 "name"=>"SYSTEM",
  				 "type"=>"EXPORT",
  				 "optional"=>"0",
  				 "def"=> array (
  					 array ("name"=>"","abap"=>"C","len"=>8,"dec"=>0)
  					)
  			),
  			 array (
  				 "name"=>"TRDIR",
  				 "type"=>"EXPORT",
  				 "optional"=>"0",
  				 "def"=> array (
  					 array ("name"=>"NAME","abap"=>"C","len"=>40,"dec"=>0),
  					 array ("name"=>"SQLX","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"EDTX","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"VARCL","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"DBAPL","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"DBNA","abap"=>"C","len"=>2,"dec"=>0),
  					 array ("name"=>"CLAS","abap"=>"C","len"=>4,"dec"=>0),
  					 array ("name"=>"TYPE","abap"=>"C","len"=>3,"dec"=>0),
  					 array ("name"=>"OCCURS","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"SUBC","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"APPL","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"SECU","abap"=>"C","len"=>8,"dec"=>0),
  					 array ("name"=>"CNAM","abap"=>"C","len"=>12,"dec"=>0),
  					 array ("name"=>"CDAT","abap"=>"D","len"=>8,"dec"=>0),
  					 array ("name"=>"UNAM","abap"=>"C","len"=>12,"dec"=>0),
  					 array ("name"=>"UDAT","abap"=>"D","len"=>8,"dec"=>0),
  					 array ("name"=>"VERN","abap"=>"C","len"=>6,"dec"=>0),
  					 array ("name"=>"LEVL","abap"=>"C","len"=>4,"dec"=>0),
  					 array ("name"=>"RSTAT","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"RMAND","abap"=>"C","len"=>3,"dec"=>0),
  					 array ("name"=>"RLOAD","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"FIXPT","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"SSET","abap"=>"C","len"=>1,"dec"=>0),
  					 array ("name"=>"SDATE","abap"=>"D","len"=>8,"dec"=>0),
  					 array ("name"=>"STIME","abap"=>"C","len"=>6,"dec"=>0),
  					 array ("name"=>"IDATE","abap"=>"D","len"=>8,"dec"=>0),
  					 array ("name"=>"ITIME","abap"=>"C","len"=>6,"dec"=>0),
  					 array ("name"=>"LDBNAME","abap"=>"C","len"=>20,"dec"=>0)
  					)
  			),
  			 array (
  				 "name"=>"PROGRAM",
  				 "type"=>"IMPORT",
  				 "optional"=>"0",
  				 "def"=> array (
  					 array ("name"=>"","abap"=>"C","len"=>40,"dec"=>0)
  					)
  			),
  			 array (
  				 "name"=>"QTAB",
  				 "type"=>"TABLE",
  				 "optional"=>"0",
  				 "def"=> array (
  					 array ("name"=>"LINE","abap"=>"C","len"=>72,"dec"=>0)
  					)
  			)
  		);

// Create list of PHP server functions
   $GLOBAL_FCE_LIST[RFC_READ_REPORT] = saprfc_function_define(0,"RFC_READ_REPORT",$DEF_RFC_READ_REPORT);

// PHP server function
   function RFC_READ_REPORT ($fce)
   {
       $REPORT = saprfc_server_import ($fce,"PROGRAM");
       saprfc_table_init ($fce,"QTAB");
       $fd = fopen ($REPORT,"r");
       if (!$fd)
           return ("NOTFOUND");     // raise exception "NOTFOUND"
       while (!feof($fd))
       {
           $LINE = fgets ($fd,73);
           saprfc_table_append ($fce,"QTAB",array("LINE"=>$LINE));
       }
       fclose ($fd);
       saprfc_server_export ($fce,"SYSTEM","PHP");
       return (true);
   }


// Call script with: ./server.php -a phpgw -g hostname -x sapgw00

   $rfc = saprfc_server_accept ($argv);

// Dispatch one function call
   $rc = saprfc_server_dispatch ($rfc,$GLOBAL_FCE_LIST);

   saprfc_close ($rfc);
?>