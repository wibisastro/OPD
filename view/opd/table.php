<table class="table filter_<?echo $pageID;?> footable toggle-circle-filled" data-page-size="12" data-filter="#filter" data-filter-text-only="false">
  <thead>
    <tr>
      <th data-type="numeric">No.</th>
      <th data-type="numeric" data-hide="phone">Nama</th>
      <th data-type="numeric" data-hide="phone" data-sort-ignore="true">Singkatan</th>
      <th data-sort-ignore="true">Kode</th>
      <th data-sort-ignore="true" data-hide="phone">Tanggal Masuk</th>
      <?if (!$_SESSION['active_client']) {?>
      <th data-sort-ignore="true"></th>
        <?} else {?>
      <th data-sort-ignore="true"></th>
        <?}?>
    </tr>
  </thead>
  <tbody id="append_<?echo $pageID;?>">
    <?
     $c=0;
     if (sizeof($data) > 0) {
      while (list($key, $val)=each($data)) {
    ?>
    <tr id="row_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>" class="row_<?echo $pageID;?>">
    <?include(VIWPATH."/$pageID/row.php");?>
    </tr>
    <?$c++;}}?>
  </tbody>
</table>
<ul class="pagination pull-right hide-if-no-paging"></ul>

<script>
function return_get(key) {
    if ('parentIFrame' in window) window.parentIFrame.sendMessage('get_key,'+key);
    return false;
}
</script>