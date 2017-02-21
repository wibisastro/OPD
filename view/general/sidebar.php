<div id="nav-col">
  <section id="col-left" class="col-left-nano">
    <div id="col-left-inner" class="col-left-nano-content">
      <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
        <ul class="nav nav-pills nav-stacked">
        <?$subscription = $api->subscription_browse($_SERVER['SERVER_NAME']);
            if (is_array($subscription)) {?>
                <li class="nav-header hidden-sm hidden-xs">
                    <i class="fa fa-cloud"></i>
                    Cloud Services
                </li>
                <?
                while (list($key,$val)=each($subscription)) {?>
                          <li>
                            <a href="javascript:void(0)" class="dropdown-toggle">
                                <i class="fa <?if ($val->icon) {echo $val->icon;} else {?>fa-cloud<?}?>"></i>
                                <span><?echo $val->service_name;?></span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                              <ul class="submenu">
                                <?if (is_array($val->tool)) {
                                    while (list($key2,$val2)=each($val->tool)) {?>
                                      <li <?if ($val2->service_id==$_GET['number']){echo "class='active'";}?>>
                                        <a href="<?echo "cloud.php?number=".$val2->service_id;?>" <?echo 'target="_top"';?>>
                                            <i class="fa <?if ($val2->icon) {echo $val2->icon;} else {?>fa-folder-o<?}?>"></i>
                                          <span><?echo $val2->caption;?></span>
                                        </a>
                                      </li>
                                    <?}?>
                                  <li>
                                    <a href="javascript:void(0)" class="dropdown-toggle">
                                        <i class="fa fa-info"></i>
                                        <span>Information</span>
                                        <i class="fa fa-angle-right drop-icon"></i>
                                    </a>
                                      <ul class="submenu">
                                        <li>
                                            <a <?if ($_GET['cp']=="set" && $val->service_id==$_GET['number']) {echo "class='active'";}?> href="cloud.php?number=<?echo $val->service_id;?>&cp=set" target="_top">
                                                Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a <?if ($_GET['cp']=="sub" && $val->service_id==$_GET['number']) {echo "class='active'";}?> href="cloud.php?number=<?echo $val->service_id;?>&cp=sub" target="_top">
                                                Subscribers
                                            </a>
                                        </li>
                                        <li>
                                            <a <?if ($_GET['cp']=="rev" && $val->service_id==$_GET['number']) {echo "class='active'";}?> href="cloud.php?number=<?echo $val->service_id;?>&cp=rev" target="_top">
                                                Reviews
                                            </a>
                                        </li>
                                        <li>
                                            <a <?if ($_GET['cp']=="log" && $val->service_id==$_GET['number']) {echo "class='active'";}?> href="cloud.php?number=<?echo $val->service_id;?>&cp=log" target="_top">
                                                Backlog
                                            </a>
                                        </li>
                                      </ul>
                                  </li>
                                <?}?>
                            </ul>
                          </li>  
            <?}}?>
          <li class="nav-header hidden-sm hidden-xs">
            <i class="fa fa-home"></i> Tools
              <?$menu=$doc->readxml("menu");?>
          </li>
        <?
        if (isset($menu)) {
            foreach ($menu->menu as $menuitem) {
            if (!$menuitem->type) {
            ?>
            <li <?if (basename($_SERVER['SCRIPT_NAME'])==basename($menuitem->url)){echo "class='active'";}?>>
                <a href="<?echo $menuitem->url;?>" target="_top">
                    <i class="fa <?if ($menuitem->icon) {echo $menuitem->icon;} else {echo "fa-file";}?>"></i>
                    <span><?echo $menuitem->caption;?></span>
                </a>
            </li>
            <?}}
        }?>
        </ul>
      </div>
    </div>
  </section>
  <div id="nav-col-submenu"></div>
</div>