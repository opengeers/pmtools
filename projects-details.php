<? 
$show=$_REQUEST['show'];
$proj_id=$db->decoded($_REQUEST['proj_id']);
if($proj_id!=''){$_SESSION['proj_id']=$proj_id;}
$where .= 'status="publish" AND type="project" AND id="'.$_SESSION['proj_id'].'"';
$db->select('post','*','',$where,'','1');
$result=$db->getResult();
?>
<div class="project">
    <div role="tabpanel">
      <!-- Nav tabs -->
      <div class="tabbar">	
          <ul class="nav nav-tabs" role="tablist">
                <li class="<?=($show=='Tasks' || $show=='')?'active':''?>"><a href="?show=Tasks"><i class="fa fa-check-square-o"></i> Tasks</a></li>
                <li class="<?=($show=='Conversations')?'active':''?>"><a href="?show=Conversations"><i class="fa fa-comment"></i> Conversations</a></li>
                <li class="<?=($show=='Notes')?'active':''?>"><a href="?show=Notes">Notes</a></li>
                <li class="<?=($show=='Files')?'active':''?>"><a href="?show=Files"><i class="fa fa-file-text"></i> Files</a></li>
                <li class="<?=($show=='About')?'active':''?>"><a href="?show=About"><i class="fa fa-info-circle"></i> About</a></li>
          </ul>
      </div>
    
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
        	<? if($show=='Files'){?>
            <div class="proj_files">
				<?
                $db->select('post_files','*','','type="project_files" AND status="publish" AND postid="'.$result[0]['id'].'"','','');
				$result_files=$db->getResult();
				foreach($result_files as $key => $val){
				$fl_type=explode('.',strrev($result_files[$key]['name']));	
				?>
					<div class="input-group">
                      <span class="input-group-addon in01"><?=strrev($fl_type[0])?></span>
                      <input type="text" class="form-control fl01" readonly aria-label="Amount (to the nearest dollar)" value="<?=$result_files[$key]['name']?>">
                      <input type="text" class="form-control fl02" name="details" value="" placeholder="Enter the details here....">
                      <span class="input-group-addon in02"><i class="fa fa-download"></i></span>
                    </div>	
				<? }?>
            </div>    
			<? }else?>
            <? if($show=='About'){?>
            	<div class="proj_about">
					<?=nl2br($result[0]['content'])?>
                </div>
			<? }else?>
            <? if($show=='Notes'){?>
            	<div class="proj_notes col2container">
					<div class="row">
                    	<div class="col-sm-5 task01">
                        	<div class="proj_task_list">
<?
$db->select('post_meta','*','','meta_key="proj_note" AND postid="'.$result[0]['id'].'"','','');
$result_notes=$db->getResult();
?>						
<div class="addnote col2hd">
    <form id="form1" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="">
    <input type="hidden" name="ref_url" value="<?=$db->encoded(URL_FULL)?>" />
    <ul class="tbl">
        <li class="tblcell col02">
        	<input type="text" class="form-control" placeholder="Search note here..."/>
        </li>
        <li class="tblcell w50 al vm col03btn"><button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button></li>
        <li class="tblcell w50 ar vm col04"><a class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i> Note</a></li>
    </ul>  
    </form>  
</div>		
<div class="table-responsive">
    <table id="table-5" cellspacing="0" cellpadding="2">
        <? $i=0;foreach($result_notes as $key => $val){$i++;?>
            <tr id="<?=$result_notes[$key]['id']?>" class="rowtd <?=($key==1)?'active':''?>">
                <td class="al">
				<?=substr($result_notes[$key]['meta_value'],0,120)?><?=(strlen($result_notes[$key]['meta_value'])>120)?'...':''?>
                <p class="task_inf">
                    <span>Notes by - <?=$result_notes[$key]['userid']?></span> |
                    <span><?=date('D, d m Y h:i:s',strtotime($result_notes[$key]['date']))?></span>
                </p>
                </td>
            </tr>
        <? }?>
    </table>
</div>
        
                            </div>
                        </div>
                        <div class="col-sm-7 task02">
                        	
                        </div>
                    </div>
                </div>
			<? }else?>
            <? if($show=='Tasks'){?>
            	<div class="proj_task col2container">
					<div class="row">
                    	<div class="col-sm-4 task01">
                        	<div class="proj_task_list">
<?
$db->select('post','*','','type="task" AND status="publish" AND parentid="'.$result[0]['id'].'"','id DESC','');
$max=$db->numRows();
?>						
<div class="taskalldiv col2hd">
	<ul class="tbl">
    	<li class="tblcell col01 w25 ac"><input type="checkbox" /></li>
        <li class="tblcell w100 col02">
        	<select class="form-control">
            	<option value="">Select...</option>
                <option value="">Assign to > </option>
                <option value="">Move to milestone > </option>
                <option value="">Marked as completed</option>
                <option value="">Delete</option>
            </select>
        </li>
        <li class="tblcell col02"><button class="btn btn-info btn-xs">Apply</button></li>
        <li class="tblcell ac w100 col03 newtaskbtn cp" data-toggle="modal" data-target="#ajax_modal"
        onclick="show_task_det('','','ajax_modal_result','task_add')"        
        ><i class="fa fa-plus-circle"></i> New Task</li>
    </ul>    
</div>	
<div class="table-responsive">
<?
if($max>0){
	$result_task=$db->getResult();	
?>
    <table id="table-5" cellspacing="0" cellpadding="2">
        <?php /*?><tr>
            <th class="w50 ac"><input type="checkbox" /></th>
            <th class="al">Title</th>
        </tr><?php */?>
        <? $i=0;foreach($result_task as $key => $val){$i++;?>
            <tr id="tasktr<?=$result_task[$key]['id']?>" class="rowtd <?=($key==0)?'active':''?>" >
                <td class="w20 ac vt"><input type="checkbox" /></td>
                <td class="al cd" onclick="show_task_det('<?=$result_task[$key]['id']?>','tasktr<?=$result_task[$key]['id']?>','col2result','task_details_ajax')">
				<?=substr($result_task[$key]['name'],0,120)?><?=(strlen($result_task[$key]['name'])>120)?'...':''?>
                <p class="task_inf">
                    <span># <?=$result_task[$key]['id']?></span> | 
                    <span><?=$result_task[$key]['proj_estimation_hr']?> Hr.</span> |
                    <span><?=date('D, d M Y h:i:s',strtotime($result_task[$key]['date']))?></span>
                </p>
                </td>
            </tr>
        <? }?>
    </table>
<? }else{?>
	<div class="nodata">You have no task.</div>
<? }?>
</div>

        
                            </div>
                        </div>
                        <div class="col-sm-8 task02">
                        	<div class="col2result" id="col2result">
                            	
                            </div>
                        </div>
                    </div>
                </div>
			<? }?>
        </div>
      </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ajax_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_result"></div>
  </div>
</div>


<div class="ajax_loader" id="ajax_loader"><i class="fa fa-circle-o-notch fa-spin"></i> Loading...</div>
<script>
	function show_task_det(id,div,resdiv,action){
		$('.rowtd').removeClass('active');
		$('#'+div).addClass('active');
		$("#ajax_loader").fadeIn("fast");
		$.ajax({url:"<?=SITE_URL?>/ajax.php",
			type: "POST",
			data: {
				action_ajax : action,
				id : id
			},
			success:function(result){
				$("#"+resdiv).html(result);
				$("#ajax_loader").fadeOut("fast");
			}
		});
	}
</script>


