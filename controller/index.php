<?
$host=explode(".",$_SERVER["HTTP_HOST"]);
require("../conf/config.php");
require("gov2model.php");
$gov2=new gov2model;
$gov2->authorize("public");
$doc->pagetitle="Portal Bappeda";

#------------------------init

$doc->content("general/index.php");
$doc->error_message();

#------------------------view
include(VIWPATH."/general/body.php");

?>