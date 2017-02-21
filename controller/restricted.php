<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
$host=explode(".",$_SERVER["HTTP_HOST"]);
require("../../".$host[0]."/conf/config.php");

require("gov2model.php");
$gov2=new gov2model;
$gov2->authorize("guess");
$doc->pagetitle="Restricted Page";
$cases=array("baca","tulis");
#------------------------process
if (!$gov2->error) {
    switch ($_GET['cmd']) {
        case "baca":
            $doc->content="ini baca";
        break;
        case "tulis":
            $doc->content="ini tulis";
        break;
        default:
            $doc->content(VIWPATH."/$pageID/index.php");
    }
}

$doc->error_message();

#------------------------view
include(VIWPATH."/general/body.php");

?>