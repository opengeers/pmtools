<?php include_once 'include/functions.php';?>
<?
$action_ajax=$_REQUEST['action_ajax'];
switch ($action_ajax){
	case 'task_add':
	?>	
      <div class="modal-header">
        <button type="button"class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create new task</h4>
      </div>
      <div class="modal-body modaldata">
        	<form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="task_add">
            <input type="hidden" name="ref_url" value="<?=$db->encoded(SITE_URL.'/projects-details?show=Tasks')?>" />
              <div class="row">
                 <?php /*?> <div class="col-sm-12 fld">Title</div><?php */?>
                  <div class="col-sm-12 val"><input type="text" name="name" class="form-control" id="recipient-name" placeholder="Task title..." data-bvalidator="required" data-bvalidator-msg="Please enter task title."></div>
              </div>
              <div class="row">
               <?php /*?>   <div class="col-sm-12 fld">Details</div><?php */?>
                  <div class="col-sm-12 val"><textarea class="form-control" name="content" id="message-text" placeholder="Write a task description..." ></textarea></div>
              </div>
              <div class="row">
                  <?php /*?><div class="col-sm-12 fld">Estimate Hr.</div><?php */?>
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
			<p class="task_name01">[#<?=$result_task[0]['id']?>] <?=$result_task[0]['name']?></p>
            <p class="task_name02"><?=$result_task[0]['content']?></p>
            <p class="task_name03">
            	<textarea class="form-control" name="content" id="message-text" placeholder="Write your comment here..." ></textarea>
            </p>
            <p class="task_name04">Files</p>
			<?
			$db->select('post_files','*','','type="task_files" AND status="publish" AND postid="'.$id.'"','','');
			$result_files=$db->getResult();
			foreach($result_files as $key => $val){
			$fl_type=explode('.',strrev($result_files[$key]['name']));	
			?>
				<div class="input-group ">
				  <span class="input-group-addon in01"><?=strrev($fl_type[0])?></span>
				  <input type="text" class="form-control fl01" readonly aria-label="Amount (to the nearest dollar)" value="<?=$result_files[$key]['name']?>">
				  <span class="input-group-addon in02"><i class="fa fa-download"></i></span>
				</div>	
			<? }?>
		</div>			
		<?
	break;


	
}
?>

<script type="text/javascript">
    $('#form1,#form2,#form3,#form4,#form5,formsubmit,#login').bValidator();
</script>