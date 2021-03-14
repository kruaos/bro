<?php
$setup=1;
if($setup==1){
// sever ออมทรัพย์
	$host = "192.168.1.1";
	$user = "root";
	$db = "finance";
	$pass="village";

}else if($setup==2){
// เครื่องเรา notebook ตัวเล็ก 
	$host = "localhost";
	$user = "root";
	$db = "finance";
	$pass = "brcb2015";

}else if($setup==3){
// เครื่องที่เทศบาล 
	$host = "localhost";
	$user = "root";
	$db = "db_br_loan";
	$pass = "";

}else if($setup==4){
// เครื่องที่บ้าน ตัวใหญ่
	$host = "localhost";
	$user = "root";
	$db = "finance3";
	$pass = "";

}else{
// เครื่องฝ่ายธนาคาร 
	$host = "127.168.1.55";
	$user = "root";
	$db = "brdbv2";
	$pass = "brcb2015";

}

$link = mysqli_connect($host,$user,$pass,$db)or die("ติดต่อไม่ได้".mysql_error()); 
mysqli_set_charset($link,'utf8');
?>
