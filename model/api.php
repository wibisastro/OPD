<?
/*
Author		: Wibisono Sastrodiwiryo
Date		: 15 April 2014
Copyleft	: eGov Lab UI
Contact		: wibi@alumni.ui.ac.id
Version		: 0.0.1
- 0.0.2 tambah browse, read, apicall - 23-03-2015
*/

//require_once __DIR__."/handshake.php";

class api {
    function apikey_status ($publickey) {
		global $config;
		$req=array("cmd"=>"apikey_status","public"=>$publickey);
		$data["req"]=json_encode($req);
		$data["apikey"]=$public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->apikey,$data);
	return json_decode($result);
	}

 	function passsync_add ($quota) {
		global $config;
        $quota+=0;
        $req=array("cmd"=>"passsync_add", "domain"=>$_SERVER['SERVER_NAME'],  "account_id"=>$_SESSION['account_id'], "app"=>"owncloud", "quota"=>$quota);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->auth,$data);
	return json_decode($result);
	}
    
    function service_read ($service_id) {
        global $config;
        $service_url=$config->platform->arch;
        $data=file_get_contents($service_url."/api.php?cmd=read&service_id=".$service_id);
	return json_decode($data);
	}
    
    function subscription_browse ($domain) {
        global $config;
        $service_url=$config->platform->arch;
        $data=file_get_contents($service_url."/api.php?cmd=subscription_browse&domain=".$domain);
	return json_decode($data);
	}
    
    function browse_menu ($webroot="") {
        $result=simplexml_load_file("http://".$_SESSION['active_client'].$webroot."/api.php?cmd=browse_menu");
	return $result;
	}
    
    function subscriber_identify ($domain) {
		global $config;
		$req=array("cmd"=>"subscriber_identify","domain"=>$domain);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->arch,$data);
	return json_decode($result);
	}

    function subscriber_identify_bykey ($apikey) {
		global $config;
		$req=array("cmd"=>"subscriber_identify_bykey","apikey"=>$apikey);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->arch,$data);
	return json_decode($result);
	}
    
#---------------- request
	function apicall ($host,$data) {
		while(list($key,$val)=each($data)) {$submit[$key]="$key=$val";}
		$body=implode("&",$submit);

		$header .= "POST $host/api.php HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($body) . "\r\n\r\n";
        if (STAGE=="dev") {$fp = fsockopen (str_replace("https://","",$host), 80, $errno, $errstr, 30);}
        else {$fp = fsockopen ('ssl://'.str_replace("https://","",$host), 443, $errno, $errstr, 30);}

		if (!$fp) {
			$result="HTTP ERROR";
		} else {
			fputs ($fp, $header . $body);
			while (!feof($fp)) {
				$line = fgets ($fp, 1024);
//                echo $line;
				if (strcmp($line, "\r\n") == 0) {
					// read the header
					$headerdone = true;
				} elseif ($headerdone) {
					// header has been read. now read the contents
					$res .= $line;
				}
			}
			fclose ($fp);
			$result=$res;
		}
		return $result;
	}  
    /*
    function subscription_browse ($domain) {
		global $config;
		$req=array("cmd"=>"subscription_browse","domain"=>$domain);
		$data["req"]=json_encode($req);
		$data["apikey"]=$public;
		$data["signature"]=md5($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->arch,$data);
	return json_decode($result);
	}
    
    function service_read ($service_id) {
		global $config;
        $service_id+=0;
		$req=array("cmd"=>"service_read","service_id"=>$service_id);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=md5($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->arch,$data);
	return json_decode($result);
	}
    */
}
?>
