<?php include 'header.php';?>
<div class="leftbar">
	<div class="logo">Opengeers...</div>
    
    <!-- Single button menu -->
    <div class="btn-group btn-block">
      <div class="creatediv" data-toggle="dropdown" >
        <i class="fa fa-plus-circle pull-left"></i> Create <i class="fa fa-angle-down pull-right"></i>
      </div>
      <ul class="dropdown-menu btn-block" role="menu">
        <li><a href="#"><i class="fa fa-briefcase"></i> Project</a></li>
        <li><a href="#"><i class="fa fa-user"></i> User</a></li>
        <?php /*?><li><a href="#"><i class="fa fa-check-square-o"></i> Task</a></li>
        <li><a href="#"><i class="fa fa-comments-o"></i> Conversation</a></li>
        <li><a href="#"><i class="fa fa-file-text-o"></i> Note</a></li>
        <li><a href="#"><i class="fa fa-tasks"></i> Task List</a></li><?php */?>        
      </ul>
    </div>

    <div class="leftmenu">
        <ul>
            <li><a href="<?=SITE_URL?>" class="<?=(URL=='')?'active':''?>"><span class="badge pull-right">25</span> <i class="fa fa-tachometer"></i> Dashboard</a></li>
            <li><a href="<?=SITE_URL?>/projects" class="<?=(URL=='projects' || URL=='projects-details')?'active':''?>"><span class="badge pull-right">184</span> <i class="fa fa-briefcase"></i> Projects</a></li>
            <li><a href="<?=SITE_URL?>/tasks" class="<?=(URL=='tasks')?'active':''?>"><span class="badge pull-right">14</span> <i class="fa fa-check-square-o"></i> Tasks</a></li>
            <li><a href="<?=SITE_URL?>/users" class="<?=(URL=='users')?'active':''?>"><span class="badge pull-right">99</span> <i class="fa fa-user"></i> Users</a></li>
            <li><a href="<?=SITE_URL?>/reporting" class="<?=(URL=='reporting')?'active':''?>"><i class="fa fa-bar-chart"></i> Reporting</a></li>
            <li><a href="<?=SITE_URL?>/chat" class="<?=(URL=='chat')?'active':''?>"><i class="fa fa-comment"></i> Chat</a></li>
            <?php /*?><li><a href=""><i class="fa fa-video-camera"></i> HD Meetings</a></li><?php */?>
        </ul>
    </div>
	
    <div class="projsearch">
    	<input type="text" name="projectname" class="form-control" placeholder="Search project here...">
    </div>
    <!-- user bottom button -->
    <div class="user_admin">
        <div class="btn-group dropup btn-block">
          <div class="creatediv" data-toggle="dropdown" >
            <img src="upload/14652_download.jpg" class="pull-left">
            Subrata Mall... <i class="fa fa-angle-up pull-right"></i>
          </div>
          <ul class="dropdown-menu btn-block" role="menu">
                <li><span>Subrata Mall...</span><a href="#" class="pull-right"><i class="fa fa-sign-out"></i>Logout</a></li>    
                <li><a href="#"><i class="fa fa-wrench"></i> Your account</a></li>
                <li><a href="#"><i class="fa fa-building-o"></i> Organization settings</a></li>
                <li class="borbtm"><a href="#"><i class="fa fa-credit-card"></i> Plans and billing - Upgrade</a></li>
                <li><a href="#"><i class="fa fa-question-circle"></i> Go to Help Center</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> Contact support</a></li>
          </ul>
        </div>
    </div>

</div>

<div class="heaerbar">
	<ul class="tbl">
        <li class="tblcell col01">Dashboard</li>
        <li class="tblcell col02 searchbox">
        	<div class="input-group">
              <input type="text" class="form-control" placeholder="Search here...">
              <span class="input-group-btn">
                <button class="btn btn-info" type="button">Go!</button>
              </span>
            </div>
        </li>
	</ul>
</div>
<div class="wrapper">
<? if(URL!=''){include(URL.'.php');}else{include('home.php');} ?>
</div>
<?php include 'footer.php';?>