<?
#------------ konvensi cybergl hanya menerima value GET dengan kriteria di bawah ini
while (list($key,$val)=each($_GET)) {
    $val=strip_tags($val);
    if (preg_match('/[^a-zA-Z0-9_.\-:]/', $val)) {header("location: invalid.html");exit;} 
    else {$_GET[$key]=$val;}
}

#----------- ini hanya untuk lingkungan pengembangan, matikan ketika masuk produksi
$_GET['error']=isset($_GET['error']) ? $_GET['error'] : '';

switch ($_GET['error']) {
    case "all":error_reporting(E_ALL);break;
    case "warning":error_reporting(E_ALL & ~E_NOTICE);break;
    default:error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);break;
}

ini_set("display_errors", 1);

#---------------------------------------path configuration
switch ($_SERVER["SERVER_NAME"]) {
    case "bappeda.gov2.web.id":
        define(DIRPATH,str_replace("/controller","",$_SERVER["DOCUMENT_ROOT"]));
        define("PATH_VENDOR","/var/www/bappeda");
        define(STAGE,"build");
    break;
    case "local.bappeda.gov2.web.id":
        define(DIRPATH,str_replace("/controller","",$_SERVER["DOCUMENT_ROOT"]));
        define("PATH_VENDOR","/var/www/bappeda");
        define(STAGE,"build");
	break;
    default:
	/*
		echo "Domain ".strtoupper($_SERVER["SERVER_NAME"])." tidak terdaftar";
		exit;
	*/
	        define(DIRPATH,str_replace("/controller","",$_SERVER["DOCUMENT_ROOT"]));
        define("PATH_VENDOR","/var/www/bappeda");
        define(STAGE,"build");
}

    define(CONPATH,DIRPATH."/controller"); #----- controller path
#---------------------------------------you can move this to improve security
    define(CNFPATH,DIRPATH."/conf"); #----- controller path
    define(MODPATH,DIRPATH."/model"); #----- model path
    define(VIWPATH,DIRPATH."/view"); #----- view path
    define(XMLPATH,DIRPATH."/xml"); #----- xml doc path
    define(TMPPATH,DIRPATH."/tmp"); #----- xml doc path

#---------------------------------------module recruiter
#-----do not change this

function getmodule ($name) {
    if (file_exists(MODPATH."/$name.php")) {require MODPATH."/$name.php";$result=new $name;} 
    else {echo "Module $name is not exist...";}
return $result;
}

#---------------------------------------initialization
#-----general client config
	$doc	= getmodule("document");
    if ($_SERVER["SERVER_NAME"]=="localhost") {$config = simplexml_load_file(XMLPATH."/config_local.xml");}
    else {$config = simplexml_load_file(XMLPATH."/config.xml");}
	$api	= getmodule("api");
    $pageID = str_replace(".php","",basename($_SERVER['SCRIPT_NAME']));

#-----specific client config
require(CNFPATH."/config_db.php");
?>