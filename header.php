<?php include_once 'include/functions.php';?>
<?
// Pagination setting
$pagfind = strpos(URL_FULL, '?');
if ($pagfind === false) {
    $pageno_url='?pageno=';
}elseif(strpos(URL_FULL, '?pageno=') === false) {
	$pageno_url='&pageno=';
}else{
    $pageno_url='?pageno=';
}
$paginationurl=explode($pageno_url,URL_FULL);
$paginationurl=$paginationurl[0];	
$pageno=1;	
if(isset($_GET['pageno']) && $_GET['pageno']!=''){$pageno=$_GET['pageno'];}	
?>
<? $msg=$_SESSION['msg']; $error=$_SESSION['error'];?>
<!DOCTYPE html>
<html>
<head>
<title>Project Management Tools - <?=(URL=='')?'Home':URL?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="<?=SITE_URL?>/images/favicon.ico" />
<!--font-awesome-->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<!--jQuery-->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--bootstrap-->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!--Custor CSS-->
<link  rel="stylesheet" href="<?=SITE_URL?>/css/style.css" type="text/css" />
<!--Custor CSS for responsive-->
<link  rel="stylesheet" href="<?=SITE_URL?>/css/media.css" type="text/css" />
</head>
<body>