<?php
class DBc
  {
    /** Put this variable to true if you want ALL queries to be debugged by default:
      */
    var $defaultDebug = false;
    /** INTERNAL: The start time, in miliseconds.
      */
    var $mtStart;
    /** INTERNAL: The number of executed queries.
      */
    var $nbQueries;
    /** INTERNAL: The last result ressource of a query().
      */
    var $lastResult;

	var $existornot; //untuk seek
	
	var $arry1; var $arry2; var $arry3;  // untu array seek
	
	var $nil; //nilai untuk jenis browser

	var $nilcount;	// nilai untuk count

    /** Connect to a MySQL database to be able to use the methods below.
      */
	  
    function DBcs($base, $server, $user, $pass)
    {
      //$this->mtStart    = $this->getMicroTime();
      $this->nbQueries  = 0;
      $this->lastResult = NULL;
      mysql_connect($server, $user, $pass) or die('Server connexion not possible.');
      mysql_select_db($base)               or die('Database connexion not possible.');
    }
	
	
	function query($query, $debug = -1)
    {
      $this->nbQueries++;
      $this->lastResult = mysql_query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query, $this->lastResult);

      return $this->lastResult;
    }
	
	// BERFUNGSI UNTUK DEBUG 74
	
	function debug($debug, $query, $result = NULL)
    {
      if ($debug === -1 && $this->defaultDebug === false)
        return;
      if ($debug === false)
        return;

      $reason = ($debug === -1 ? "Default Debug" : "Debug");
      $this->debugQuery($query, $reason);
      if ($result == NULL)
        echo "<p style=\"margin: 2px;\">Number of affected rows: ".mysql_affected_rows()."</p></div>";
      else
        $this->debugResult($result);
    }
	
	function debugQuery($query, $reason = "Debug")
    {
      $color = ($reason == "Error" ? "red" : "orange");
      echo "<div style=\"border: solid $color 1px; margin: 2px;\">".
           "<p style=\"margin: 0 0 2px 0; padding: 0; background-color: #DDF;\">".
           "<strong style=\"padding: 0 3px; background-color: $color; color: white;\">$reason:</strong> ".
           "<span style=\"font-family: monospace;\">".htmlentities($query)."</span></p>";
    }
	
	function debugResult($result)
    {
      echo "<table border=\"1\" style=\"margin: 2px;\">".
           "<thead style=\"font-size: 80%\">";
      $numFields = mysql_num_fields($result);
      // BEGIN HEADER
      $tables    = array();
      $nbTables  = -1;
      $lastTable = "";
      $fields    = array();
      $nbFields  = -1;
      while ($column = mysql_fetch_field($result)) {
        if ($column->table != $lastTable) {
          $nbTables++;
          $tables[$nbTables] = array("name" => $column->table, "count" => 1);
        } else
          $tables[$nbTables]["count"]++;
        $lastTable = $column->table;
        $nbFields++;
        $fields[$nbFields] = $column->name;
      }
      for ($i = 0; $i <= $nbTables; $i++)
        echo "<th colspan=".$tables[$i]["count"].">".$tables[$i]["name"]."</th>";
      echo "</thead>";
      echo "<thead style=\"font-size: 80%\">";
      for ($i = 0; $i <= $nbFields; $i++)
        echo "<th>".$fields[$i]."</th>";
      echo "</thead>";
      // END HEADER
      while ($row = mysql_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < $numFields; $i++)
          echo "<td>".htmlentities($row[$i])."</td>";
        echo "</tr>";
      }
      echo "</table></div>";
      $this->resetFetch($result);
    }
	
	// 74 END BLOG
	
	// digunakan untuk update, delate, insert
	//$db->execute("Insert into pegawai values('0762215','Abdulloh','Cerme','Gresik','l','2009')");  
	//$db->execute("Delete from pegawai where id_pegawai='0762215'");  
	function execute($query, $debug = -1)
    {
      $this->nbQueries++;
      mysql_query($query) or $this->debugAndDie($query);
      $this->debug($debug, $query);
    }
	
	
	//untuk mengeluarkan hasil report
	//$result = $koneksi->Query("select * from sapsp.sapsp_user");
	//$jumlah = count($result);
	//while($line = $db->fetchNextObject($result)){  
	//echo $line->sapsp_user_login;

	function fetchNextObject($result = NULL)
    {
      if ($result == NULL)
        $result = $this->lastResult;

      if ($result == NULL || mysql_num_rows($result) < 1)
        return NULL;
      else
        return mysql_fetch_object($result);
    }
	
	
	function debugAndDie($query)
    {
      $this->debugQuery($query, "Error");
      die("<p style=\"margin: 2px;\">".mysql_error()."</p></div>");
    }
	
	function close()
    {
      mysql_close();
    }
	
	function seek($query, $con)
	{
		$result = mysql_query($query) or $this->debugAndDie($query);
		if(mysql_num_rows($result) > 0)
		{
			$arr = mysql_fetch_array($result);
			$this->existornot=1;
			if ($con==1)
			{
			$this->arry1=$arr[0];
			$this->arry2=$arr[1];
			$this->arry3=$arr[2];
			}
		}
		else
		{
			$this->existornot=0;
		}		
	}
	
	function getQueriesCount()
    {
      return $this->nbQueries;
    }
	
	function browser()
	{	
	$useragent = $_SERVER ['HTTP_USER_AGENT'];
	if (strpos($useragent,"Firefox"))
	{ $nil=1;}
	elseif (strpos($useragent,"Chrome"))
	{ $nil=2;}
	elseif (strpos($useragent,"pera"))
	{ $nil=3;}
	elseif (strpos($useragent,"MSIE"))
	{ $nil=4;}
	elseif (strpos($useragent,"SeaMonkey"))
	{ $nil=5;}
	elseif (strpos($useragent,"Flock"))
	{ $nil=6;}
	elseif (strpos($useragent,"Safari"))
	{ $nil=7;}
	elseif (strpos($useragent,"Orca"))
	{ $nil=8;}
	$this->nil=$nil;	
	}

	
	function sCountW($table, $fields, $cond)
	{
		//select count(*) from sapsp.sapsp_trans where left(sapsp_trans_ip,2) = '19';
		$query = "select count(*) from ".$table." where left(".$fields.",2) = '".$cond."'";
		$result = mysql_query($query) or $this->debugAndDie($query);
		$arr = mysql_fetch_array($result);
		$this->nilcount=$arr[0];
	}	
	
}
?>