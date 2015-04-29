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
			<? }?>
            <? if($show=='About'){?>
            	<div class="proj_about">
					<?=nl2br($result[0]['content'])?>
                </div>
			<? }?>
            <? if($show=='Notes'){?>
            	<div class="proj_notes">
                	<div class="proj_notes_add">
                        <form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="proj_note_add">
                        <input type="hidden" name="ref_url" value="<?=$db->encoded(URL_FULL)?>" />
                        <div class="row">
                            <div class="col-sm-12 val"><textarea name="note" value="" class="form-control tarea" data-bvalidator="required" data-bvalidator-msg="Please enter some note." placeholder="Enter your note here...."></textarea></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 val"><button class="btn btn-info" name="" type="submit">Submit</button></div>
                        </div>
                        </form>
                    </div>
                    <div class="proj_notes_list">
					<?
					$db->select('post_meta','*','','meta_key="proj_note" AND postid="'.$result[0]['id'].'"','','');
					$result_note=$db->getResult();
					foreach($result_note as $key => $val){
					?>
						  <ul class="proj_notes_list_ul">
                          	<li class="noteby01"><?=$result_note[$key]['meta_value']?></li>
                            <li class="noteby02">Notes by : <?=$result_note[$key]['userid']?> on <?=date('D, d M Y / h:i:s',strtotime($result_note[$key]['date']))?> </li>
                          </ul>	                  
                    <? }?>
                    </div>
                </div>
			<? }?>
            <? if($show=='Tasks'){?>
            	<div class="proj_task">
					<div class="row">
                    	<div class="col-sm-5 task01">
                        	<div class="proj_task_list">
<?
$db->select('post_meta','*','','meta_key="proj_note" AND postid="'.$result[0]['id'].'"','','');
$result_task=$db->getResult();
?>						
<div class="taskalldiv">
	<ul class="tbl">
    	<li class="tblcell col01 w50 ac"><input type="checkbox" /></li>
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
        <li class="tblcell ac w100 col03 newtaskbtn"><i class="fa fa-plus-circle"></i> New Task</li>
    </ul>    
</div>		
<div class="table-responsive">
    <table id="table-5" cellspacing="0" cellpadding="2">
        <?php /*?><tr>
            <th class="w50 ac"><input type="checkbox" /></th>
            <th class="al">Title</th>
        </tr><?php */?>
        <? $i=0;foreach($result_task as $key => $val){$i++;?>
            <tr id="<?=$result_task[$key]['id']?>" class="rowtd <?=($key==1)?'active':''?>">
                <td class="w50 ac"><input type="checkbox" /></td>
                <td class="al">
				<?=substr($result_task[$key]['meta_value'],0,150)?><?=(strlen($result_task[$key]['meta_value'])>150)?'...':''?>
                <p class="task_inf">
                	<span><a><i class="fa fa-plus-circle"></i> Sub Task</a></span> |
                    <span>ID - <?=$result_task[$key]['id']?></span> | 
                    <span>Total time : 154hr.</span>
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
			<? }?>
        </div>
      </div>
    </div>
</div>