<? $show=$_REQUEST['show'];?>
<div class="project">
    <div role="tabpanel">
      <!-- Nav tabs -->
      <div class="tabbar">	
          <ul class="nav nav-tabs" role="tablist">
                <li class="<?=($show=='')?'active':''?>"><a href="?show="><i class="fa fa-briefcase"></i> Projects</a></li>
                <li class="<?=($show=='add_project')?'active':''?>"><a href="?show=add_project"><i class="fa fa-plus"></i> Add</a></li>
          </ul>
      </div>
    
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
        	<? if($show=='add_project'){?>
            	<div class="add_project">
                	<form id="form1" action="<?=SITE_URL?>/process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="project_add">
                    <input type="hidden" name="ref_url" value="<?=$db->encoded(URL_FULL)?>" />
                    <div class="row">
                        <div class="col-sm-12 fld">Title</div>
                        <div class="col-sm-12 val"><input type="text" name="name" value="" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please enter project title."/></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 fld">Description</div>
                        <div class="col-sm-12 val"><textarea name="content" value="" class="form-control tarea" data-bvalidator="required" data-bvalidator-msg="Please enter project details."></textarea></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 fld">Upload documents</div>
                        <div class="col-sm-12 val"><input type="file" multiple="multiple" name="proj_files[]" /></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 fld">Client name</div>
                        <div class="col-sm-12 val"><input type="text" name="client_name" value="" class="form-control" /></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 fld">Client skype id</div>
                        <div class="col-sm-12 val"><input type="text" name="client_skype" value="" class="form-control" /></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 fld">Client phone</div>
                        <div class="col-sm-12 val"><input type="text" name="client_phone" value="" class="form-control" /></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 fld">Client email</div>
                        <div class="col-sm-12 val"><input type="text" name="client_email" value="" class="form-control" /></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 val"><button class="btn btn-info" name="" type="submit">Submit</button></div>
                    </div>
					</form>
				</div>
            <? }?>
            <? if($show==''){?>
            <div class="project_list">
            <div class="table-responsive">
			<? 
            $user_search_key=$_REQUEST['user_search_key'];
            if($user_search_key!=''){
            $where = '( `name` LIKE "%'.$user_search_key.'%" OR content LIKE "%'.$user_search_key.'%" ) AND ';	
            }
            $where .= 'status="publish" AND type="project"';
            $db->select('post','*','',$where,'name ASC',''); 
            $max=$db->numRows();
            if($max>0){?>
            	<table class="table">
                    <tr class="trhead">
                      <th class="col01">ID#</th>
                      <th class="col02">Title</th>
                      <th class="col03">Description</th>
                      <th class="col04">Date</th>
                      <th class="col05">Action</th>
                    </tr>
            <?
            $result=$db->getResult();
            foreach($result as $key => $val){
            ?>
                    <tr>
                      <td class="col01"><?=$result[$key]['id']?></td>
                      <td class="col02"><a href="<?=SITE_URL?>/projects-details?proj_id=<?=$db->encoded($result[$key]['id'])?>&show=Tasks"><?=$result[$key]['name']?></a></td>
                      <td class="col03"><?=substr($result[$key]['content'],0,100)?> <?=(strlen($result[$key]['content'])>200)?'.....':''?></td>
                      <td class="col04"><?=date('D, d M Y',strtotime($result[$key]['date']))?></td>
                      <td class="col05">
                        <div class="action">                            
                            <?php /*?><div class="panel panel-default actionpopup">
                              <!-- Default panel contents -->
                              <i class="fa fa-caret-right setrarw"></i>
                              <div class="panel-heading">Setting</div>
                              <!-- List group -->
                              <ul class="list-group">
                                <li class="list-group-item"> 
                                    <a class="" href="<?=SITE_URL?>/projects-details?proj_id=<?=$db->encoded($result[$key]['id'])?>&show=task"><i class="fa fa-tasks pull-right"></i> Task</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="" href="process.php?action=export&type=xls&proj_id=<?=$db->encoded($result[$key]['id'])?>"><i class="fa fa-file-excel-o editicon pull-right"></i> Download .XLS</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="" href="process.php?action=export&type=pdf&proj_id=<?=$db->encoded($result[$key]['id'])?>"><i class="fa fa-file-pdf-o editicon pull-right"></i> Download .PDF</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="" href="process.php?action=export&type=preview&proj_id=<?=$db->encoded($result[$key]['id'])?>" target="_blank"><i class="fa fa-eye editicon pull-right"></i> Preview</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="" href="?show=edit&proj_id=<?=$db->encoded($result[$key]['id'])?>"><i class="fa fa-pencil editicon pull-right"></i> Edit</a>
                                </li>
                                <li class="list-group-item">
                                    <a class="" href="<?=SITE_URL?>/process.php?action=proj_delete&proj_id=<?=$db->encoded($result[$key]['id'])?>&ref_url=<?=$db->encoded(URL_FULL)?>" onClick="return confirm('Are you sure to delete this record?')"><i class="fa fa-times deleteicon pull-right"></i> Delete</a>
                                </li>
                              </ul>
                            </div><?php */?>
                            <i class="fa fa-cog setng"></i>
                        </div>            
                      </td>
                    </tr>
            <? }?>        
                  </table>
            <? }else{?>
            	<div class="nodata">You have no project, Please add new project by click on above "Add" link.</div>
            <? }?>    
            </div>
            </div>
            <? }?>            
        </div>
      </div>
    </div>

</div>
