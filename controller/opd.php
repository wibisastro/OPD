<?
/********************************************************************
*   Date        : 25 May 2016
*   Author      : Wibisono Sastrodiwiryo
*   Email       : wibi@cybergl.co.id
*   Copyright   : PT Cyber Gatra Loka. All rights reserved.
*********************************************************************/
$host=explode(".",$_SERVER["HTTP_HOST"]);
require("../../".$host[0]."/conf/config.php");

require("gov2model.php");
$cases=array("guest","add","remove","update");
$gov2=new gov2model;
$gov2->authorize("member");
#------------------------init
$main=getmodule("opd");
$doc->pagetitle="Organisasi Perangkat Daerah";
#------------------------process

if (!$gov2->error) {
    if ($_POST) {
        switch($_POST["cmd"]) {
            case "add":
                if (!$_POST['nama']) {$doc->error="Uncomplete";}
                else {
                    $_POST['account_id']=$gov2->authorized['account_id'];
                    $id=$main->{$pageID."_add"}($_POST);
                    $response=$main->{$pageID."_read"}($id);
                }
                include(VIWPATH."/scaffold/response.php");
                exit;
              break;
            case "remove":
                if (!$_POST[$pageID.'_id']) {$doc->error="NoID";}
                else {$main->{$pageID."_remove"}($_POST);}
                include(VIWPATH."/scaffold/response.php");
                exit;
              break;
            case "update":
                if (!$_POST['nama']) {$doc->error="Uncomplete";}
                else {
                    $main->{$pageID."_update"}($_POST);
                    $response=$main->{$pageID."_read"}($_POST[$pageID.'_id']);
                    $c = $_POST["no"];
                }
                include(VIWPATH."/scaffold/response.php");
                exit;
              break;
            default:
        }
    } else {
        switch($_GET["cmd"]) {
            case "identify":
                $_SESSION['servicepage']=$_SERVER['SCRIPT_NAME'];
                header("location: gov2auth.php?".$_SERVER["QUERY_STRING"]);
            break;
            case "add":
                include(VIWPATH."/scaffold/add.php");
                exit;
            break;
            case "edit":
                if (!$_GET[$pageID.'_id']) {$doc->error="NoID";}
                else {
                    $edit=$main->{$pageID."_read"}($_GET[$pageID."_id"]);
                    $edit->no = $_GET["no"];
                }
                include(VIWPATH."/scaffold/edit.php");
                exit;
            break;
            default:
                if (!$_SESSION['active_client']) {
                    $scaffold['addbutton']=true;
                    $scaffold['remove']=true;
                    $scaffold['form']='default';
                }
                // $main->opd_history($_GET["parent"]);
                // $breadcrumb=$main->breadcrumb_path($main->history);
                $data=$main->{$pageID."_browse"}($_GET["parent"]);
                $parent=$main->{$pageID."_read"}($_GET["parent"]);
                $doc->content("scaffold/browse.php");
                $doc->content("opd/remove_sub.php");

        }
    }

} elseif ($_GET["cmd"]=="identify") {
    $_SESSION['servicepage']=$_SERVER['SCRIPT_NAME'];
    $_SESSION['landingpage']="gov2auth.php?".$_SERVER["QUERY_STRING"];
    header("location: ".account_url."/slogin.php?servicepage=1&client=".$_SERVER["SERVER_NAME"]);
    exit;
}
$doc->error_message();

#------------------------display
include(VIWPATH."/general/body.php");
?>


