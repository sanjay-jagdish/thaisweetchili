<?php session_start();
	include '../config/config.php';
	
	$main_cat = 0;
	$sub_cat = 0;
	$cat=mysql_real_escape_string(strip_tags($_POST['cat']));
	$cattype=mysql_real_escape_string(strip_tags($_POST['cattype']));
	$name=mysql_real_escape_string($_POST['name']);
	$des=mysql_real_escape_string($_POST['des']);
	$price=mysql_real_escape_string(strip_tags($_POST['price']));
	$currency=mysql_real_escape_string(strip_tags($_POST['currency']));
	$featured=mysql_real_escape_string(strip_tags($_POST['featured']));
	$menutype=mysql_real_escape_string(strip_tags($_POST['menutype']));
	$img=mysql_real_escape_string(strip_tags($_POST['img']));
	$takeaway_price=mysql_real_escape_string(strip_tags($_POST['takeaway_price']));
	$discount_unit=mysql_real_escape_string(strip_tags($_POST['discount_unit']));
	$takeaway_tillval=mysql_real_escape_string(strip_tags($_POST['takeaway_tillval']));
	
	if($cattype == "maincat"){
		$main_cat = $cat;
		$sub_cat = 0;
		$q=mysql_query("select id from menu where name='".$name."' and cat_id=".$main_cat." and deleted=0") or die(mysql_error());
	}elseif($cattype == "subcat"){
		$main_cat = 0;
		$sub_cat = $cat;
		$q=mysql_query("select id from menu where name='".$name."' and sub_category_id=".$sub_cat." and deleted=0") or die(mysql_error());
	}
	
	if(mysql_num_rows($q) > 0){
		echo 'Invalid';
	}
	else{
		//mysql_query("insert into menu(sub_category_id,currency_id,name,description,price,image,featured,type,discount) values(".$cat.",".$currency.", '".$name."', '".$des."', '".$price."', '".$img."',".$featured.",'".$menutype."',".$discount.")") or die(mysql_error());
		mysql_query("insert into menu(cat_id,sub_category_id,currency_id,name,description,price,image,type,takeaway_price,discount_unit,featured,single_option) values(".$main_cat.",".$sub_cat.",".$currency.", '".$name."', '".$des."', '".$price."', '".$img."','".$menutype."','".$takeaway_price."','".$discount_unit."',".$featured.",'".$takeaway_tillval."')") or die(mysql_error());
		$id = mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()"));
		echo $id[0];
		
		mysql_query("insert into log(account_id,description,date_time,ip_address) values(".$_SESSION['login']['id'].",'Added a menu(".$name.")',now(),'".get_client_ip()."')");
		
	}
	
?>