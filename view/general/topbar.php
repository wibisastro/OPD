<header class="navbar" id="header-navbar">
  <div class="container">
    <a href="index.php" id="logo" class="navbar-brand">
      <img src="images/logo-admin.png" alt="" class="normal-logo logo-white"/>
      <!-- <img src="images/logo-admin-black.png" alt="" class="normal-logo logo-black"/>
      <img src="images/logo-admin-black.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/> -->
    </a>

    <div class="clearfix">
    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="fa fa-bars"></span>
    </button>

    <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
      <ul class="nav navbar-nav pull-left">
        <li>
          <a class="btn" id="make-small-nav">
            <i class="fa fa-bars"></i>
          </a>
        </li>
        <li class="dropdown">
        <?//include(VIWPATH."/general/notification.php");?>
        </li>
      </ul>
    </div>

<div class="nav-no-collapse pull-right" id="header-nav">
      <ul class="nav navbar-nav pull-right">
        <?if ($config->service->login=="open") {?>
            <li class="dropdown profile-dropdown">
              <?if ($_SESSION["account_id"]){?>
              <a class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?if ($_SESSION["photourl"]) {echo $_SESSION["photourl"];} else {echo "http://sso.gov2.web.id/images/user.png";}?>" alt="<?echo $_SESSION["fullname"];?>"/>
                <span class="hidden-xs">
                <?echo $_SESSION["fullname"];?>
                </span> <b class="caret"></b>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="login.php"><i class="fa fa-user"></i>Profile</a></li>
                <li><a href="gov2login.php?cmd=logout"><i class="fa fa-power-off"></i>Logout</a></li>
              </ul>
              <?}else{?>
              <a href="login.php" style="display:inline-block">Login</a><a href="login.php?cmd=signup" style="display:inline-block">Signup</a>
              <?}?>
            </li>
        <?}?>
        <?if ($_SESSION["account_id"]){?>
        <li>
            <a class="sidepanel btn_panel">
                <i class="fa fa-arrow-circle-left" id="panel_button_top"></i>
            </a>
        </li>
        <?}?>
      </ul>
    </div>
    </div>
  </div>
</header>