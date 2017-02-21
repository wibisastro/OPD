<div class="row">
  <div class="col-lg-12">
    <div class="main-box clearfix" id="table_<?echo $pageID;?>">
        <header class="main-box-header clearfix">
          <h2 class="pull-left">Records (<?echo count($data);?>)</h2>
          <div class="filter-block pull-right">
            <div class="form-group pull-left">
                <input type="text" id="filter" class="form-control" placeholder="Search...">
                <i class="fa fa-search search-icon"></i>
            </div>
            <a href="<?echo $_SERVER['SCRIPT_NAME'];?>?cmd=add" class="table-link" target="iframer">
            <button type="button" class="btn btn-primary pull-right">
                <i class="fa fa-plus-circle fa-lg"></i> Add Data
            </button>
            </a>
          </div>
        </header>


      <div id="response_alert_<?echo $pageID;?>"></div>

      <div class="main-box-body clearfix">
        <?include(VIWPATH."/$pageID/table.php");?>
      </div>
    </div>
  </div>
</div>

<!--modal remove-->
  <div class="modal fade" id="remove<?echo $pageID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <?include(VIWPATH."/scaffold/remove.php");?>
  </div>
  <!--end modal-->

<!--modal for form-->
  <?include(VIWPATH."/$pageID/form.php");?>
</div>