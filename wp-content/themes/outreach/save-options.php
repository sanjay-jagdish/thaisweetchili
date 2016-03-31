<?php
	include 'config.php';
	
	$menu_id = $_POST['menu_id'];
	$uniq = $_POST['uniq'];
	$notes = $_POST['notes'];
	$res_detail_id = $_POST['res_detail_id'];
	$addons = explode('^',$_POST['addons']);
	
	//save notes
	mysql_query("update reservation_detail set notes='".$notes."' where id='".$res_detail_id."'") or die(mysql_error());
	
	//delete first the reservation_menu_option
	
	mysql_query("delete from reservation_menu_option where reservation_unique_id='".$uniq."' and menu_id='".$menu_id."'") or die(mysql_error());
	
	//save menu options
	for($i=0;$i<count($addons);$i++){
		
		$adds=explode('*',str_replace('opt_','',$addons[$i]));
		
		$str = explode('-',$adds[0]);
		
		$price = $adds[1];
		$name = $adds[2];
		$dishnum = $str[0];
		$menu_option_id = $str[1];
		
		mysql_query("insert into reservation_menu_option(reservation_unique_id, menu_option_id, menu_id, name, price, dish_num) values('".$uniq."', '".$menu_option_id."', '".$menu_id."', '".$name."', '".$price."', '".$dishnum."')") or die(mysql_error());
		
	}
	
?>