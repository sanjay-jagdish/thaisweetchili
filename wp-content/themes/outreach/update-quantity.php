<?php
	include 'config.php';
	
	if($_POST['type']=='update'){
		
		mysql_query("update reservation_detail set quantity=(quantity-1) where id='".$_POST['id']."'");
		
		mysql_query("delete from reservation_menu_option where reservation_unique_id='".$_POST['uniq']."' and dish_num='".$_POST['dishnum']."'");
		
	}
	else{
		mysql_query("delete from reservation_detail where id='".$_POST['id']."'");
	}
?>	