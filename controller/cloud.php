<?
/********************************************************************
*	Date		: 11 Nov 2014
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: PT Cyber GovLab 
*********************************************************************/
$host=explode(".",$_SERVER["HTTP_HOST"]);
require("../../".$host[0]."/conf/config.php");
require("gov2model.php");

#------------------------init
$cases=array("guest");
$gov2=new gov2model;
$gov2->authorize($cases[0]);

#------------------------controller
if (!$gov2->error) {
    if ($_POST['cmd']) {
  //      echo print_r($_POST);
        switch($_POST['cmd']) {
            case "ontop_panel":
                $_SESSION['ontop_panel']['url']=$_POST['url'];
                $_SESSION['ontop_panel']['icon']=$_SESSION['cloud_icon'];
                $_SESSION['ontop_panel']['caption']=$_SESSION['cloud_caption'];
                echo print_r($_SESSION);
                exit;
            break;
            case "offtop_panel":
                unset($_SESSION['ontop_panel']);
                exit;
            break;
        }
    } else {
        $data=$api->service_read($_GET['number']);
        $checkstatus=$api->service_read($data->parent);
        if($checkstatus->status!=='active'){$doc->error='ServiceNotActive';}
        else {
            $doc->pagetitle=$data->caption;
            $timestamp = new DateTime();

            $_SESSION['active_cloud']=parse_url($data->link, PHP_URL_HOST);
            $_SESSION['cloud_icon']=$data->icon;
            $_SESSION['cloud_caption']=$data->caption;
            $_GET['number']+=0;

            if ($_GET['cp']) {
                switch($_GET['cp']) {
                    case "set":
                        $data->link=$config->platform->arch."/setting.php";
                    break;
                    case "sub":
                        $data->link=$config->platform->arch."/subscriber.php";
                    break;
                    case "rev":
                        $data->link=$config->platform->arch."/review.php";
                    break;
                    case "log":
                        $data->link=$config->platform->arch."/backlog.php";
                    break;
                }
                $cp="&service_id=".$_GET['number'];
            } else {
                if ($_GET['number']==9) {
                    $catalog="&catalog=".$config->catalog->criteria."&criteria=".$config->catalog->value;
                }     
            }
            $data->link=$data->link."?cmd=identify&apikey=".$config->apikey->public."&client=".$_SERVER["SERVER_NAME"].$catalog.$cp."&webroot=".$config->webroot."&timestamp=".$timestamp->getTimestamp(); 
            $doc->content("general/cloud.php");
        }
    }
} else {
    $_GET['number']+=0;
    if (!$_GET['cp']) {$_SESSION["landingpage"]="cloud.php?number=".$_GET['number'];}
    else {$_SESSION["landingpage"]="cloud.php?number=".$_GET['number']."&cp=".$_GET['cp'];}
    header("location: login.php");
    exit;
}

$doc->error_message();

#------------------------view
include(VIWPATH."/general/body.php");
?>