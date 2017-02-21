<body onload="loadPage()">
<div id="response_alert_<?echo $pageID;?>">
<?if ($doc->error) {?>
    <div class="main-box-body clearfix">
    <div class="alert alert-danger fade in" style="margin-bottom:0">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-times-circle fa-fw fa-lg"></i>
        <strong><?echo $doc->error;?></strong> <?echo $doc->txt($doc->error);?>
    </div>
    </div>
<?} else {?>
    <div class="main-box-body clearfix">
    <div class="alert alert-success fade in" style="margin-bottom:0">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-check-circle fa-fw fa-lg"></i>
        <strong>Berhasil</strong> Informasi telah berhasil diperbaharui.
    </div>
    </div>
<?}?>
</div>
<?if ($_POST['cmd']=="add" || $_POST['cmd']=="update") {?>
    <table id="append_<?echo $pageID;?>">
    <tr id="row_<?echo $pageID;?>_<?echo $response->{$pageID."_id"};?>" class="row_<?echo $pageID;?>">
        <?
        $val=$response;
        include(VIWPATH."/$pageID/row.php");
        ?>
    </tr>
    </table>
<?}?>
<SCRIPT LANGUAGE="JavaScript">
<!--

function loadPage() {
  if (window == parent) return;
  else {
	var ref_source=document.getElementById('response_alert_<?echo $pageID;?>').innerHTML;
    parent.document.getElementById('response_alert_<?echo $pageID;?>').innerHTML=ref_source;
<?if ($data->error) {
    switch($_POST['cmd']) {
        case "add":
        case "remove":
        ?>parent.closeForm_<?echo $pageID;?>();<?
        break;
        case "remove":
        ?>parent.closeRemove_<?echo $pageID;?>();<?
        break;
    }
} else {
    if ($_POST['cmd']=="add") {?>
      var newRow=document.getElementById('append_<?echo $pageID;?>').innerHTML;
      parent.document.getElementById('append_<?echo $pageID;?>').innerHTML=parent.document.getElementById('append_<?echo $pageID;?>').innerHTML+newRow;
      parent.document.getElementById('row_<?echo $pageID?>_<?echo $response->{$pageID."_id"};?>').style.backgroundColor = '#dff0d8';
	  parent.closeForm_<?echo $pageID;?>();
	  parent.updateFootable();
	  parent.showAdded();
    <?} elseif ($_POST['cmd']=="remove") {?>
	  parent.closeRemove_<?echo $pageID;?>();
	  parent.RemoveUpdate_<?echo $pageID;?>('<?echo $_POST[$pageID.'_id'];?>');
    <?} elseif ($_POST['cmd']=="update") {?>
	  parent.closeForm_<?echo $pageID;?>();
      var updatedRow=document.getElementById('row_<?echo $pageID?>_<?echo $response->{$pageID."_id"};?>').innerHTML;
      parent.document.getElementById('row_<?echo $pageID?>_<?echo $response->{$pageID."_id"};?>').innerHTML=updatedRow;
      parent.document.getElementById('row_<?echo $pageID?>_<?echo $response->{$pageID."_id"};?>').style.backgroundColor = '#dff0d8';
	  parent.updateFootable();
	  parent.showUpdated('<?echo $response->{$pageID."_id"};?>');
    <?}
}?>
  }
}
//-->
</SCRIPT>
</body>