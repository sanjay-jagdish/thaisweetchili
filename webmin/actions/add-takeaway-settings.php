<?php session_start();
	include '../config/config.php';
	$starttime = mysql_real_escape_string(strip_tags($_POST['starttime']));
	$endtime = mysql_real_escape_string(strip_tags($_POST['endtime']));
	$days = mysql_real_escape_string(strip_tags($_POST['days']));
	$startdate = mysql_real_escape_string(strip_tags($_POST['startdate']));
	$enddate = mysql_real_escape_string(strip_tags($_POST['enddate']));
	$advancetime = mysql_real_escape_string(strip_tags($_POST['advancetime']));
	
	$sql = "select * from takeaway_settings where start_date = '$startdate' and end_date = '$enddate' and deleted = 0";
	if(mysql_num_rows($sql)>0){
		echo 'Exist';	
	}else{
		mysql_query("insert into takeaway_settings(days,start_time,end_time,start_date,end_date,advance_time) values('".$days."', '".$starttime."', '".$endtime."','".$startdate."','".$enddate."','".$advancetime."')") or die('Insert: '.mysql_error());
	
	
	mysql_query("insert into log(account_id,description,date_time,ip_address) values(".$_SESSION['login']['id'].",'Added a Takeaway Setting.',now(),'".get_client_ip()."')") or die('Log: '.mysql_error());
	}
	
?>