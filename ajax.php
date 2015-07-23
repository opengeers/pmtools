<?php include_once 'include/functions.php';?>
<?
$where="id=".$_SESSION['user_info']['id']."";
$db->select('user','*','',$where);
$userexit=$db->numRows();
$user=$db->getResult();

$action_ajax=$_REQUEST['action_ajax'];
switch ($action_ajax){
	case 'task_add':
	$id=$_REQUEST['id'];
	?>	
      <div class="modal-header">
        <button type="button"class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><? if($id!=''){?>Add sub task  under #<?=$id?><? }else{?>Create new task<? }?></h4>
      </div>
      <div class="modal-body modaldata">
        	<form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="task_add">
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="ref_url" value="<?=$db->encoded(SITE_URL.'/projects-details?show=Tasks&id='.$id.'')?>" />
              <div class="row">
                  <div class="col-sm-12 fld">Title</div>
                  <div class="col-sm-12 val"><input type="text" name="name" class="form-control" id="recipient-name" placeholder="Task title..." data-bvalidator="required" data-bvalidator-msg="Please enter task title."></div>
              </div>
              <div class="row">
                  <div class="col-sm-12 fld">Details</div>
                  <div class="col-sm-12 val"><textarea class="form-control" name="content" id="message-text" placeholder="Write a task description..." ></textarea></div>
              </div>
              <div class="row">
                  <div class="col-sm-12 fld">Estimate Hr.</div>
                  <div class="col-sm-3 val"><input type="text" class="form-control" name="proj_estimation_hr" placeholder="Estimate Hr." id="recipient-name"></div>
              </div>
              <div class="row">
					<input type="file" multiple name="proj_files[]" />                    
              </div>
              <div class="row">
					<button type="submit" class="btn btn-info">Save Task</button>              
              </div>
            </form>
      </div>
	<?
	break;

	case 'task_details_ajax':
		$id=$_REQUEST['id'];
		$db->select('post','*','','type="task" AND status="publish" AND id="'.$id.'"','','');
		$result_task=$db->getResult();
		?>
        <div class="task_details_ajax">
        		<div class="btn-group btn btn-default btn-xs pull-right">
                  <div class="" data-toggle="dropdown" >
                    <i class="fa fa-plus-circle"></i> Action
                  </div>
                  <ul class="dropdown-menu btn-block task_setting">
                    <li><a class="" data-toggle="modal" data-target="#ajax_modal" onclick="show_task_det('<?=$result_task[0]['id']?>','tasktr<?=$result_task[0]['id']?>','ajax_modal_result','task_edit')"  ><i class="fa fa-pencil"></i> Edit</a></li>
                    <? if($result_task[0]['parentid_task']==0){?>
                    <li><a class="" data-toggle="modal" data-target="#ajax_modal" onclick="show_task_det('<?=$result_task[0]['id']?>','tasktr<?=$result_task[0]['id']?>','ajax_modal_result','task_add')" ><i class="fa fa-hand-o-right"></i> Add Sub Task</a></li>
                    <? }?>
                    <li><a class=""><i class="fa fa-hand-o-right"></i> Assign</a></li>
                    <li><a class=""><i class="fa fa-check-square-o"></i> Mark as Completed</a></li>
                  </ul>
                </div>
			<p class="task_name01">[#<?=$result_task[0]['id']?>] <?=$result_task[0]['name']?></p>
            <p class="task_name02"><?=nl2br($result_task[0]['content'])?></p>
            <p class="task_name02">Estimation Time <strong><?=$result_task[0]['proj_estimation_hr']?> Hr.</strong></p>
			<?
			$db->select('post_files','*','','type="task_files" AND status="publish" AND postid="'.$id.'"','','');
			$result_files=$db->getResult();
			foreach($result_files as $key => $val){
			$fl_type=explode('.',strrev($result_files[$key]['name']));	
			?>
				<p class="taskfiles">
                	<i class="fa fa-paperclip"></i> <?=$result_files[$key]['name']?> 
                	<a href="" class="btn btn-default btn-xs" ><i class="fa fa-download"></i></a>
                    <a href="" class="btn btn-default btn-xs"><i class="fa fa-trash"></i></a>
                </p>
                <?php /*?><div class="input-group">
				  <span class="input-group-addon in01"><i class="fa fa-file"></i> <?=strrev($fl_type[0])?></span>
				  <input type="text" class="form-control fl01" readonly aria-label="Amount (to the nearest dollar)" value="<?=$result_files[$key]['name']?>">
				  <span class="input-group-addon in02"><i class="fa fa-download"></i></span>
                  <span class="input-group-addon in02"><i class="fa fa-trash-o"></i></span>
				</div>	<?php */?>
			<? }?>
            <form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="comment_add">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="ref_url" value="<?=$db->encoded(SITE_URL.'/projects-details?show=Tasks&id='.$id.'')?>" />
                <p class="task_name03">
                    <textarea class="form-control tarea h25" name="content" id="message-text" placeholder="Write your comment here..." data-bvalidator="required" data-bvalidator-msg="Please enter your comment."></textarea>
                </p>
                <p class="task_name03"><input type="file" multiple name="proj_files[]" /></p>
                <p class="task_name03"><button type="submit" class="btn btn-info btn-sm">Submit Comment</button></p>
            </form>
            <?
			$db->select('post','*','','type="task_comment" AND status="publish" AND parentid="'.$id.'"','date DESC','');
			$result_comment=$db->getResult();
			foreach($result_comment as $key => $val){
			?>
            	<div class="commentlst">
                	<strong>Subrata Mallik  - <?=date('D, d M Y / h:i:s',strtotime($result_comment[$key]['date']))?> </strong><?=nl2br($result_comment[$key]['content'])?>
					<?
                    $db->select('post_files','*','','type="task_files" AND status="publish" AND postid="'.$result_comment[$key]['id'].'"','','');
                    $result_files=$db->getResult();
                    foreach($result_files as $key => $val){
                    $fl_type=explode('.',strrev($result_files[$key]['name']));	
                    ?>
                        <p class="taskfl"><i class="fa fa-paperclip"></i> <?=$result_files[$key]['name']?></p>
                    <? }?>                
                </div>
            <? }?>
		</div>			
		<?
	break;
	
	case 'task_edit':
	$id=$_REQUEST['id'];
	$db->select('post','*','','type="task" AND status="publish" AND id="'.$id.'"','','');
	$result_task=$db->getResult();
	?>	
      <div class="modal-header">
        <button type="button"class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update task #<?=$id?></h4>
      </div>
      <div class="modal-body modaldata">
        	<form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="task_edit">
            <input type="hidden" name="id" value="<?=$result_task[0]['id']?>">
            <input type="hidden" name="ref_url" value="<?=$db->encoded(SITE_URL.'/projects-details?show=Tasks&id='.$id.'')?>" />
              <div class="row">
                  <div class="col-sm-12 fld">Title</div>
                  <div class="col-sm-12 val"><input type="text" name="name" value="<?=$result_task[0]['name']?>" class="form-control" id="recipient-name" placeholder="Task title..." data-bvalidator="required" data-bvalidator-msg="Please enter task title."></div>
              </div>
              <div class="row">
                  <div class="col-sm-12 fld">Details</div>
                  <div class="col-sm-12 val"><textarea class="form-control tarea" name="content" id="message-text" placeholder="Write a task description..." ><?=$result_task[0]['content']?></textarea></div>
              </div>
              <div class="row">
                  <div class="col-sm-12 fld">Estimate Hr.</div>
                  <div class="col-sm-3 val"><input type="text" class="form-control" name="proj_estimation_hr" value="<?=$result_task[0]['proj_estimation_hr']?>" placeholder="Estimate Hr." id="recipient-name"></div>
              </div>
              <div class="row">
					<button type="submit" class="btn btn-info">Update Task</button>              
              </div>
            </form>
      </div>
	<?
	break;


	
}
?>

<script type="text/javascript">
    $('#form1,#form2,#form3,#form4,#form5,formsubmit,#login').bValidator();
</script>