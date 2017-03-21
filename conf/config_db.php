<?
#---------------------------------------cybergl platform tables configuration
    $tbl_opd        = "opd";

#---------------------------------------database classes

class db_connection {
	function connect_db($db_server="") {
		static $recent_random;
        switch (STAGE) {
            case "build":
				$db["master"]["dbname"]	= "code4_opd";
                $db["master"]["user"]	= "code4opd";
				$db["master"]["pass"]	= "";
				$db["master"]["host"]	= "localhost";
            break;
            default:
				$db["master"]["dbname"]	= "bappeda";
				$db["master"]["user"]	= "root";
				$db["master"]["pass"]	= "";
				$db["master"]["host"]	= "localhost";
        }
		switch ($db_server) {
			case "renjakl":
				$db_link_id=mysqli_connect($db["renjakl"]["host"], $db["renjakl"]["user"], $db["renjakl"]["pass"],$db["renjakl"]["dbname"]) or die("Unable to connect to SQL server 'renjakl'");
			break;
			default:
				$db_link_id=mysqli_connect($db["master"]["host"], $db["master"]["user"], $db["master"]["pass"],$db["master"]["dbname"]) or die("Unable to connect to SQL server 'master'");
		}
		$result=array($db_link_id,$db_name,$random);
	return $result;
	}

	function write_db($query,$fname,$table="",$db="master") {
		list($db_link_id,$db_name)=$this->connect_db($db);
		$this->read_db($db_name,$query,$db_link_id) or die("$fname: ($db)".mysql_error());

		if ($table) {
			$result=mysqli_fetch_object($this->read_db($db_name, "SELECT LAST_INSERT_ID() AS id FROM $table",$db_link_id));
			$query=str_replace("(null","($result->id",$query);
		}
	return $result->id;
	}

	function read_db($db_name, $query, $db_link_id) {
       $result = mysqli_query($db_link_id,$query);
       if (!$result) {
               echo "Fail to execute query:".$query;
               exit;
       }
       return $result;
   }
   
	function read_enum($table,$field) {
		list($db_link_id,$db_name)=$this->connect_db();
		$query="DESCRIBE $table";
		$daftar = $this->read_db($db_name, $query,$db_link_id) or die("browse: ".mysqli_error($db_link_id));
		while ($buffer = mysqli_fetch_object($daftar)) {
			if ($buffer->Field==$field) {
				$result=str_replace("enum(", "",$buffer->Type);
				$result=str_replace(")", "", $result);
				$result=str_replace("'", "", $result);
				$result=explode(",", $result);
			}
		}
		return $result;
	}
}
?>