<?if (basename($_SERVER['SCRIPT_NAME'])=="cloud.php") {?>
    <!-- <header class="main-box-header clearfix">
    <div class="icon-box pull-left clearfix">
        <?if($breadcrumb){
            echo $breadcrumb;            
        }?>
        <h1><i class="fa <?echo $data->icon;?>" id="cloud_icon"></i>
            <span id="cloud_caption"><?echo $doc->pagetitle;?></span>
        </h1>        
    </div>
    <div class="icon-box pull-right">
        <a href="javascript:void(0)" class="btn pull-left" id="cloud_refresh">
            <i class="fa fa-refresh"></i>
        </a>
        <a href="javascript:void(0)" class="btn pull-left" id="share_to_panel">
            <i class="fa fa-share"></i>
        </a>
    </div>
    </header> -->
<?} else {?>
    <header class="main-box-header clearfix">
        <?if($breadcrumb){
            echo $breadcrumb;            
        }?>
        <h1><?echo $doc->pagetitle;?></h1>        
    </header> 
<?}?>