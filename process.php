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
		$arvalue['userid']=$user[0]['id'];
		
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

	
	case 'task_add':
		$arvalue['name']=$db->escapeString($_POST['name']);
		$arvalue['content']=$db->escapeString($_POST['content']);
		$arvalue['proj_estimation_hr']=$db->escapeString($_POST['proj_estimation_hr']);
		$arvalue['date']=DATE;		
		$arvalue['type']='task';
		$arvalue['status']='publish';
		$arvalue['userid']=$user[0]['id'];
		$arvalue['parentid']=$_SESSION['proj_id'];		
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
					'task_files','date'=>DATE,'ip'=>IP,'status'=>'publish');
					$db->insert("post_files",$array);	
					$photocount++;
					$_SESSION['error']=0;
				}else{
					$photocounterror++;
					$_SESSION['error']=1;	
				}
			}
		}
		
		$_SESSION['msg']='Task has been added successfully.';
		$_SESSION['error']=0;
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
	
	case 'comment_add':	
		$id=$_POST['id'];
		$arvalue['content']=$db->escapeString($_POST['content']);
		$arvalue['date']=DATE;		
		$arvalue['type']='task_comment';
		$arvalue['status']='publish';
		$arvalue['userid']=$user[0]['id'];
		$arvalue['parentid']=$id;		
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
					'task_files','date'=>DATE,'ip'=>IP,'status'=>'publish');
					$db->insert("post_files",$array);	
					$photocount++;
					$_SESSION['error']=0;
				}else{
					$photocounterror++;
					$_SESSION['error']=1;	
				}
			}
		}
		
		$_SESSION['msg']='Comment has been added successfully.';
		$_SESSION['error']=0;
		$db->redirect($ref_url);
		break;
		
		case 'task_edit':
			$id=$_POST['id'];
			$arvalue['name']=$db->escapeString($_POST['name']);
			$arvalue['content']=$db->escapeString($_POST['content']);
			$arvalue['proj_estimation_hr']=$db->escapeString($_POST['proj_estimation_hr']);
			$arvalue['modified_date']=DATE;		
			$db->update('post',$arvalue,'id="'.$id.'"'); // insert into database		
			$_SESSION['msg']='Task has been updated successfully.';
			$_SESSION['error']=0;
			$db->redirect($ref_url);	
		break;
		
}
?>