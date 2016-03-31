<?php
if($_GET['pdf']==1){
	ob_start();	
	echo '<page style="box-sizing:border-box;" backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">';
}else{
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mise en Place</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>    
<?php    
}

require '../config/config.php';

$year_num = $_GET['year'];
$week_num = $_GET['week'];

$currency_shortname = '';
$currency_sql = "SELECT shortname FROM currency WHERE set_default=1";
$currency_qry = mysql_query($currency_sql);
$currency_res = mysql_fetch_assoc($currency_qry);

//check if there is an existing lunch menu for the week
$menu_week_sql = "SELECT * FROM menu_lunch WHERE year_for=".$year_num." AND week_no=".$week_num;
$menu_week_qry = mysql_query($menu_week_sql);
$menu_week_num = mysql_num_rows($menu_week_qry);
$menu_week_check_num = $menu_week_num;

$none_all_in = 0;

if($menu_week_num==0){
	$menu_week_sql = "SELECT * FROM menu_lunch WHERE year_for<=".$year_num." AND week_no<=".$week_num." ORDER BY year_for DESC, week_no DESC LIMIT 1";
	$menu_week_qry = mysql_query($menu_week_sql);
	$menu_week_num = mysql_num_rows($menu_week_qry);	

	//flag 1=true to exclude courses that are not marked as "all-in"
	$none_all_in = 1;

}

?>

<style>
body{
	background-color: #fff;
	color: #000;
	font-family: sans-serif;
	font-size: 1.6rem;
	font-weight: 300;
	margin: 0px 24px;
}

h1, h2, h3, h4, h5, h6 {
    color: #333;
    font-family: Lato,sans-serif;
    font-weight: 700;
    line-height: 1.2;
}

.widgettitle{
	color: #580605;
	font-size: 40px;
	/*text-align: center;*/
	font-weight: 700;
	text-transform:uppercase;	
}

h1{
	color: #580605;
	font-size: 20px;
	/*text-align: center;*/
	font-weight: 700;
	text-transform:uppercase;	
}


span.left_background {
    padding: 12px 0px 13px 122px;
    background: url('http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/widget_title_left.png') no-repeat scroll left center<?php if($_GET['pdf']==0){ echo ' transparent'; }?>;
	font-size:32px !important;
}

span.right_background {
    padding: 12px 122px 12px 0px;
    background: url('http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/widget_title_right.png') no-repeat scroll right center<?php if($_GET['pdf']==0){ echo ' transparent';} ?>;
}


.themenu-outer {
    /*text-align: center;*/
	margin:0 auto;
	/*width: 430px;/*760px;*/
	/*border: solid thin red;*/
}

.weeknum {
    color: #580605 !important;
    font-size: 25px !important;
    font-weight: 700 !important;
    line-height: 1.2 !important;
    margin-bottom: 10px !important;
    display: block !important;
}


.footer{
    /* text-align: center; */
    margin: 50px 0px;
    color: #000;
	font-size:16px;
}

.thesepa {
	clear:both;
    width: 282px;
    height: 36px;
    margin: 30px auto;
}


.themenu-inner h3 {
    margin-bottom: 5px;
	font-size:22px !important;
}

h3 {
    font-size: 18px;
	padding-top:12px;
	color: #580605;
	font-family: lato,sans-serif;
	font-size: 2rem;
	font-style: normal;
	font-weight: 700;
}

h5 {
    font-size: 16px;
	font-weight:700;
}

p{
	 margin:0px !important; 
	 padding:8px !important;	
}

div.menus p{
	 margin:0px !important; 
	 padding:0px 0px 12px 0px !important;	
}

.dish_name{
	color: #580605; font-family: sans-serif; font-weight: 900; font-style: normal; font-size: 18px; line-height:12px; margin-bottom:0px;
}	

</style>

<?php	
$menu_week_res = mysql_fetch_assoc($menu_week_qry);

if($_GET['pdf']==0){
?>
<!--
<div style="top:0; right:24px; position:absolute; width: 200px; text-align:right; line-height:34px;">
    <a class="link_button" id="pdf_export" data-rel="" title="Export as PDF">Export as PDF</a>
</div>
-->
<?php
}
?>

<div class="themenu-outer">

    <h4 class="widget-title widgettitle" style="text-align:center;">
    	<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/widget_title_left.png" style="vertical-align:middle;">        
    	&nbsp; Veckans Lunch &nbsp;
    	<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/widget_title_right.png" style="vertical-align:middle;">
    </h4>

    <h1 style="text-align:center;"><b>Vecka <?php echo $week_num; ?></b></h1>    

    <p style="color: #580605; font-family: sans-serif; font-weight: 900; font-style: normal; font-size: 18px; line-height:12px !important;">
        <b><?php echo stripslashes($menu_week_res['note_header']); ?></b>
	</p>
        
	<p style="color: #000; font-family: helvetica neue,helvetica,arial,sans-serif; font-size: 16px; line-height:10px !important; font-style: normal;">
		<?php echo stripslashes($menu_week_res['description']); ?>
    </p>
    <br>
    
    <p style="text-align:center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/separator.png"></p>

	<div class="menu">

    <?php
	
	if($none_all_in==0){
		$all_in_switch = '';
	}else{
		$all_in_switch = ' AND all_in=1 ';	
	}

    $courses_sql = "SELECT * FROM menu_lunch_items WHERE 
					menu_id=".$menu_week_res['id']."
					".$all_in_switch."
					AND specific_day IS NULL 
					AND deleted=0
					ORDER BY `order`, id ASC";
    $courses_qry = mysql_query($courses_sql);
    $courses_num = mysql_num_rows($courses_qry);
	
	
	if($courses_num>0){

		while($courses_res = mysql_fetch_assoc($courses_qry)){
		$counts++;
		$menu_price = '';
		?>

            <span class="dish_name">
				<?php echo stripslashes($courses_res['name']); ?>
            </span>

            <div class="testp<?php echo $counts; ?>"><?php echo stripslashes($courses_res['description']); ?></div>

			<?php
			if($courses_res['price']>0){
				$menu_price = number_format($courses_res['price'],0).' '.$currency_res['shortname']; 
			}
			?>
			<style type="text/css">
				.testp<?php echo $counts; ?> :after{
					content: '<?php echo ' '.$menu_price; ?>';
				}
			</style>
			 <?php 

		}//looping thru courses for this menu
	

	}
	
	?>
    
 	<p style="text-align:center; padding-bottom:0px !important;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/separator.png"></p>
   
    <?php
	
	$first_day = strtotime('monday this week');
	$last_day = strtotime('saturday this week');
	$the_day = $first_day;
	
	$week_days = 6;
	
	for($d=1; $d<=$week_days; $d++){

		$courses_sql = "SELECT * FROM menu_lunch_items WHERE 
						menu_id=".$menu_week_res['id']."
						".$all_in_switch."
						AND specific_day='".date('D', $the_day)."' 
						AND deleted=0
						ORDER BY `order`, id ASC";

		$courses_qry = mysql_query($courses_sql);
		$num_courses = mysql_num_rows($courses_qry);

	
		if($num_courses>0){
	
			while($courses_res = mysql_fetch_assoc($courses_qry)){
		?>	
            <p style="color: #580605; font-family: sans-serif; font-weight: 900 !important; font-style: normal; font-size: 18px; line-height:12px; margin-bottom:0px;">
                	<b><?php echo stripslashes($courses_res['name']); ?></b>
            </p>
                
                <p data-rel="description">
	
				<?php echo stripslashes($courses_res['description']); ?>
				<?php 
				if($courses_res['price']>0){
					echo number_format($courses_res['price'],0).'&nbsp;'.$currency_res['shortname']; 
				}
				?>
				</p>
	
		<?php	
			}

		?>
        
  </div>      
        
  <p style="text-align:center; margin-top:8px;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/webmin/images/separator.png"></p>
        
        <?php
	
		}

		$the_day = strtotime(date('Y-m-d', $the_day).' +1 day');
	}	
	?>
	<p><?php echo stripslashes($menu_week_res['note_footer']); ?></p>

</div>

<?php
if($_GET['pdf']==1){
	echo '</page>';
    
	$content = ob_get_clean();
    // convert in PDF
    //require_once(dirname(__FILE__).'/../html2pdf.class.php');
	require_once('../html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
		//$fontname = $html2pdf->addTTFfont('fonts/latoregular.ttf', 'TrueTypeUnicode', '', 32);
		//$html2pdf->addFont('Lato', '', $file='fonts/latoregular.ttf');
        $html2pdf->setDefaultFont('helvetica');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Lunch Meny.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

}else{
?>
</body>
</html>
<?php	
}
?>