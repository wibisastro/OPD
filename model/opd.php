<?
/********************************************************************
*	Date		: 17 Nov 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI
********************************************************************/

class opd extends db_connection {

    function opd_browse($parent=0) {
    	global $tbl_opd;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT * FROM $tbl_opd order by opd_id";
		$daftar = $this->read_db($db_name, $query,$db_link_id) or die("browse: ".mysqli_error($db_link_id));
        $c=0;
		while ($buffer = mysqli_fetch_object($daftar)) {$result[$c]=$buffer;$c++;}
	return $result;
	}

    function opd_read ($opd_id) {
		global $tbl_opd;
        $opd_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT * FROM $tbl_opd WHERE opd_id=$opd_id";
		$buffer=$this->read_db($db_name, $query,$db_link_id) or die("opd_read: ".mysqli_error($db_link_id));
		$result=mysqli_fetch_object($buffer);
	return $result;
	}

    function opd_add($data) {
	    global $tbl_opd;
	    $data[account_id]+=0;
	    $query ="INSERT INTO $tbl_opd VALUES(null,0, '$data[nama]', '$data[singkatan]', '$data[kode]',$data[account_id],NOW())";
	    $id=$this->write_db($query,"opd_add",$tbl_opd);
	return $id;
	}

	function opd_remove($data) {
	    global $tbl_opd;
	    $data[account_id]+=0;
	    $query ="DELETE FROM $tbl_opd WHERE opd_id='$data[opd_id]'";
	    $this->write_db($query,"opd_del");
	}

	function opd_update($data,$opd_id) {
	    global $tbl_opd;
	    $opd_id+=0;
	    $query ="UPDATE $tbl_opd SET
	    	nama='$data[nama]',
	    	singkatan='$data[singkatan]',
	    	kode='$data[kode]'
	    WHERE opd_id=$data[opd_id]";
	    echo $query;
	    $this->write_db($query,"opd_update");
	}

	function opd_history ($opd_id) {
		global $tbl_opd;
        static $c;
		$opd_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT opd_id,parent,nama,level FROM bappenas_staging.opd_h WHERE opd_id=$opd_id";
		//echo $query;
		$buffer=mysqli_fetch_object($this->read_db($db_name,$query,$db_link_id));
        $c++;
		$this->history[$c]=$buffer;
		if ($buffer->parent>0){$this->opd_history($buffer->parent);}
	}

	function opd_history_path ($data) {
		global $doc; //print_r($data);
		krsort($data);
		if($data[1]->opd_id){
			$result="<div class=\"alert alert-info\"><table>";
		} else {
			$result="";
		}
        $c=1;
		while (list($key,$val)=each($data)) {
			if ($val->opd_id && $c < sizeof($data)) {$result.="<tr><td><strong>".strtoupper($val->level)."</strong></td><td style=\"padding-left:20px\">: ".$doc->lnk($_SERVER['SCRIPT_NAME']."?parent=$val->opd_id",$val->nama)."</td></tr>";}
            else if ($val->opd_id) {$result.="<tr><td style=\"width:10%\"><strong>".strtoupper($val->level)."</strong></td><td style=\"padding-left:20px\">: ".$val->nama."</td></tr>";}
            $c++;
		}
		if($data[1]->opd_id){$result.="</table></div>";}
	return $result;
	}

	function breadcrumb_path ($data) {
		global $doc;
		krsort($data);

		$listlevel=array("program","opd","kegiatan","ppn","pkl");
		$result="<ol class=\"breadcrumb\"><li style=\"text-transform:uppercase;\"><a href=\"".$_SERVER[SCRIPT_NAME]."\">".$listlevel[0]."</a></li>
		";
        $c=1;
		while (list($key,$val)=each($data)) {
			$temp_tingkat=array_search($val->level, $listlevel);
			$tingkat=$temp_tingkat+1;
			$level=$listlevel[$tingkat];

			if ($val->opd_id && $c < sizeof($data)) {$result.="<li style=\"text-transform:uppercase;\"><span>".$doc->lnk($_SERVER['SCRIPT_NAME']."?parent=$val->opd_id",$level)."</span></li>";}
            else if ($val->opd_id) {$result.="<li class=\"active\" style=\"text-transform:uppercase;\"><span>".$level."</span></li>";}
            $c++;
		}
		$result.="</ol>";
	return $result;
	}

  	function opd_confirm_delete ($opd_id) {
		global $tbl_opd;
      	$opd_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT opd_id AS upper FROM $tbl_opd WHERE parent=$opd_id";
		$result = mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));
	return $result;
	}
}
?>