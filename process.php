<?php include_once 'include/functions.php';?>
<?
$ref_url=$db->decoded($_REQUEST['ref_url']);

$where="id=".$_SESSION['user_info']['id']."";
$db->select('user','*','',$where);
$userexit=$db->numRows();
$user=$db->getResult();

$action=$_REQUEST['action'];
switch ($action){
	case 'project_add':
		$arvalue['name']=$db->escapeString($_POST['name']);
		$arvalue['content']=$db->escapeString($_POST['content']);
		$arvalue['client_name']=$db->escapeString($_POST['client_name']);
		$arvalue['client_skype']=$db->escapeString($_POST['client_skype']);
		$arvalue['client_phone']=$db->escapeString($_POST['client_phone']);
		$arvalue['client_email']=$db->escapeString($_POST['client_email']);
		$arvalue['date']=DATE;		
		$arvalue['type']='project';
		$arvalue['status']='publish';
		$arvalue['userid']='1';
		
		$db->insert('post',$arvalue); // insert into database		
		$result=$db->getResult();		
		//Upload profile picture
		foreach ($_FILES["proj_files"]["error"] as $key => $error) {
			if ($error != 4) {
			$tmp_name = $_FILES["proj_files"]["tmp_name"][$key];
			$name = time().$_FILES["proj_files"]["name"][$key];
			$typeimg=strtolower(end(explode('.',$name)));
				if($typeimg!='.php' || $typeimg!='exe' || $typeimg!='.net'){
					move_uploaded_file($tmp_name, "upload/$name");	
					$array=array('postid'=>$result[0],'name'=>$name,'path'=>'upload','type'=>
					'project_files','date'=>DATE,'ip'=>IP,'status'=>'publish');
					$db->insert("post_files",$array);	
					$photocount++;
					$_SESSION['error']=0;
				}else{
					$photocounterror++;
					$_SESSION['error']=1;	
				}
			}
		}
		
		$_SESSION['msg']='Project has been saved successfully.';
		$_SESSION['error']=0;
		$db->redirect($ref_url);		
	break;

	
	case 'savesite':
		$arvalue['name']=$db->escapeString($_POST['name']);
		$arvalue['content']=$db->escapeString($_POST['content']);
		$arvalue['type']='site_client';
		$arvalue['status']='publish';
		$arvalue['date']=DATE;		
		$arvalue['userid']=$user[0]['id'];
		$db->insert('post',$arvalue); // insert into database		
		$_SESSION['msg']='Site has been saved successfully.';
		$_SESSION['error']=0;
		$db->redirect($ref_url);
	break;
	
	case 'updatesite':
		$arvalue['name']=$db->escapeString($_POST['name']);
		$arvalue['content']=$db->escapeString($_POST['content']);
		$site_client_id=$db->escapeString($_POST['site_client_id']);
		$db->update('post',$arvalue,'id='.$site_client_id.''); // update into database		
		//echo $db->getSql();
		$_SESSION['msg']='Site has been updated successfully.';
		$_SESSION['error']=0;
		$db->redirect($ref_url);
	break;
	
	case 'delect_site_client':		
		$site_client_ids=$_POST['site_client_ids'];	
		$db->delete('post','id in ("'.implode('","',array_values($site_client_ids)).'")');
		$db->redirect($ref_url);
	break;
	
	case 'proj_note_add':
		$arvalue['meta_value']=$db->escapeString($_POST['note']);
		$arvalue['meta_key']='proj_note';		
		$arvalue['postid']=$_SESSION['proj_id'];
		$arvalue['date']=DATE;		
		$arvalue['userid']=$user[0]['id'];
		$db->insert('post_meta',$arvalue); // insert into database		
		$_SESSION['msg']='Note has been saved successfully.';
		$_SESSION['error']=0;
		$db->redirect($ref_url);
	break;
	
	
}
?>