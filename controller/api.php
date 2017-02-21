<?
/********************************************************************
*	Date		: 31 Mar 2016
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: PT Cyber Gatra Loka. All rights reserved.
*********************************************************************/
$host=explode(".",$_SERVER["HTTP_HOST"]);
require("../../".$host[0]."/conf/config.php");
require("gov2model.php");

#------------------------init
$cases=array("public","");
$gov2=new gov2model;
$gov2->authorize($cases[0]);
//$folder=getmodule("folder");
#------------------------process

if ($_POST) {
  if ($_POST["cmd"]=="auth") {
	  echo $api->apicall_response($_POST);
	  exit;
  } else {
	  $apicall_id=$api->apicall_auth($_POST);
	  $valid=$api->apicall_read($apicall_id);
	  if ($valid->status=="closed") {
		  $data=json_decode(stripslashes($_POST["req"]),1);
		  while(list($key,$val)=each($data)) {${"$key"}=$val;}
	  } else {$cmd="fail";}
  }

  switch($cmd) {
	case "fail":
        $response["status"]="fail";
        $response["message"]=$valid->status;
        $response["cmd"]=$cmd;
        echo json_encode($response);
	break; 
	default:
      $response["status"]="fail";
      $response["message"]="nocase";
      $response["cmd"]=$cmd;
      echo json_encode($response);
  }
} else {
	switch($_GET[cmd]){
            /*
        case "browse_menu":
            $data=file_get_contents(xmlpath."/menu.xml");
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: text/xml');
            echo $data;
        exit;
        break;
        case "read":
            if ($_GET['service_id']) {
                $data=$service->service_read($_GET['service_id']);
                echo json_encode($data);
                exit;
            } else {$doc->error="Uncomplete";}
        break; 
        */
        case "download":
            if ($_GET['account_id']) {
                $_GET['account_id']+=0;
                $zipfile = TMPPATH."/".$_GET['account_id'].".zip";
                $file_name = basename($zipfile);
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: Binary");
                header("Content-Disposition: attachment; filename=$file_name");
                header("Content-Length: " . filesize($zipfile));
                readfile($zipfile);
            } else {echo "InvalidID";}
            exit;
        break; 
        default:
	}
}

#--------view
$result["comm"]="ok";
json_encode($result);
?>