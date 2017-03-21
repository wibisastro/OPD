  <td><?echo $c+1;?></td>
  <td><?echo $val->nama;?></td>
  <td><?echo $val->singkatan;?></td>
  <td><?echo $val->kode;?></td>
  <td><?echo $val->tanggal_masuk;?></td>

  <?if (!$_SESSION['active_client']) {?>
  <td class="text-center">
      <a href="<?echo $_SERVER['SCRIPT_NAME'];?>?cmd=edit&no=<?echo $c;?>&<?echo $pageID;?>_id=<?echo $val->{$pageID."_id"};?>" class="table-link" target="iframer">
        <span class="fa-stack">
          <i class="fa fa-square fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
        </span>
      </a>
      <a href="#remove<?echo $pageID;?>" data-toggle="modal" data-<?echo $pageID;?>_id="<?echo $val->{$pageID."_id"};?>" data-item="<?echo $val->nama;?>" class="table-link danger">
        <span class="fa-stack">
          <i class="fa fa-square fa-stack-2x"></i>
          <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
        </span>
      </a>
      <a class="row-delete" href="#" id="del_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>"></a>
  </td>
  <?} else {?>
  <td>
      <a href="javascript:void(0)" class="table-link primary" onclick="share_to_panel('<?echo $val->prioritas_id?>');">
          <i class="fa fa-share-square-o"></i>
      </a>
  </td>
  <?}?>

