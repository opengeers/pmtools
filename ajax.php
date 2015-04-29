<?php include_once 'include/functions.php';?>
<?
$where="id=".$_SESSION['user_info']['id']."";
$db->select('user','*','',$where);
$userexit=$db->numRows();
$user=$db->getResult();
$action_ajax=$_REQUEST['action_ajax'];
switch ($action_ajax){
	case 'code_edit':
		$code_id=$_POST['code_id'];
		$code_type=$_POST['code_type'];
		
		$db->select('post','*','','id='.$code_id.'');
		$result=$db->getResult();
		?>
		<script>
			<? if($code_type=='html_code'){?>
				$('.html_pro input[name="name"]').val("<?=$result[0]['name']?>");
				$('.html_pro textarea[name="video_code_input"]').html('<?=$result[0]['video_code_input']?>');
			<? }?>
		</script>
		<?
		
			
	break;
}
?>