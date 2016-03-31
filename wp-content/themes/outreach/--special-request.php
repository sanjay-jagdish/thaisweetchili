<?php
	include 'config.php';
	
	$q=mysql_query("select * from reservation_detail where id='".$_POST['id']."'");
	$r=mysql_fetch_assoc($q);
	
	function checkOption($id,$dishnum){
		
		$str='';
		
		$q=mysql_query("select id from reservation_menu_option where reservation_unique_id='".$_COOKIE['takeaway_id']."' and menu_option_id='".$id."' and dish_num='".$dishnum."'"); 
		
		if(mysql_num_rows($q)>0){
			$str='checked="checked"';
		}
		
		return $str; 
	}
	
	function getMenuImage($id){
		$q=mysql_query("select image from menu where id='".$id."'");
		$r=mysql_fetch_assoc($q);
		
		return $r['image'];
	}

//SPECIAL REQUEST BOX HEADER
?> 
     <div class="special_request_menu">
        <h4><?php echo $_POST['menu_det'];?></h4>
        
        <?php 
		if(getMenuImage($r['menu_id'])!=''){ ?>
        	<style>
            	.special_request_menu h4 { float: left; }
            </style>
            
			<div class="thedish-img">
				<img src="<?php echo $_SERVER['HTTP_REFERER']; ?>/webmin/uploads/<?php echo getMenuImage($r['menu_id']); ?>" class="dish-image">
			</div> <?php
         }	
?>
 </div>
 
 


<div class="specialbox">
<table>
    <tr>
    	<?php
        	$opt_q = mysql_query("select * from menu_option_details where menu_id = $r[menu_id] order by order_by, id") or die(mysql_error());
			
			$theoptioncount = mysql_num_rows($opt_q);
			
			if($theoptioncount>0){
		?>
        <td style="vertical-align:top;" class="option-side">
        
        <?php 
							if($theoptioncount>0){
							?>
                             <!--<div><input type="button" style="font-size:12px; padding:8px 18px; border-radius:0;" class="toggleopt" alt="opt-holder-<?php //echo $r['id'];?>" value="Tillval"></div>-->
                             <?php if($r['quantity']>1){
								echo '<div style="padding-left:10px;" class="cart-opt" id="opt-holder-'.$r['id'].'">';
								 for ($x=1; $x <= number_format($r['quantity']); $x++) {
									 	echo '<div class="btn-'.$x.'-'.$r['id'].'"><input type="button" style="font-size:12px; padding:8px 18px; text-transform:none; border-radius:0;" class="toggleoptin" alt="dish-holder-'.$x.'-'.$r['id'].'" value="Portion #'.$x.'"><a href="javascript:void(0)" class="remove-tillval" data-id="dish-holder-'.$x.'-'.$r['id'].'" data-rel="btn-'.$x.'-'.$r['id'].'" data-title="'.$r['id'].'" data-count="'.$x.'">X</a></div>';
										
										$query_opt = mysql_query("select *, if(order_by=0,'A',order_by) as theorderby from menu_option_details where menu_id = $r[menu_id] order by theorderby, id") or die(mysql_error());
										
										echo '<div class="cart-opt" id="dish-holder-'.$x.'-'.$r['id'].'">';
										
										$theradiocount=0;
										
										while($opt = mysql_fetch_assoc($query_opt)){
											
											$theradiocount++;
											
											$qry=mysql_query("select id, name, price, if(order_by=0,'A',order_by) as theorderby from menu_options where menu_option_detail_id='".$opt['id']."' order by theorderby, id");
											
											?>
                                            <h5 class="h5<?php echo $opt['id']; ?>"><?php echo $opt['name']; ?></h5>
                                            <?php
											
											$cnt=0;
											$total_cnt=mysql_num_rows($qry);
											$okay=0;
											
											while(list($optid, $optname, $optprice) = mysql_fetch_array($qry)){
										
												$cnt++;
										
											$pr_mu = ($optprice!=0) ? number_format($optprice,0).' '.getCurrentCurrency() : '';
											
										?>	
											<div>
												<?php if($opt['single_option']==0){ ?>
                                                <input type="checkbox" rel="st-<?php echo $r['id']; ?>" alt="<?php echo $optprice; ?>" id="opt_<?php echo $x; ?>-<?php echo $optid; ?>" style="width:auto;" <?php echo checkOption($optid,$x);  ?>/>&nbsp;<label style="width:150px;" for="opt_<?php echo $x; ?>-<?php echo $optid; ?>" title="<?php echo $optname; ?>" class="theopt-name"><?php echo $optname; ?></label><span class="opt-pr-cur"><label><?php echo $pr_mu; ?></label></span>
                                                <?php }
                                                else{ ?>
                                                <input type="radio" rel="st-<?php echo $r['id']; ?>" alt="<?php echo $optprice; ?>" id="opt_<?php echo $x; ?>-<?php echo $optid; ?>" style="width:auto;" name="opt-radio-<?php echo $theradiocount.'-'.$x.'-'.$r['id']; ?>" <?php 
												
												if(checkOption($optid,$x)!=''){
													echo 'checked="checked"';
													$okay=1;
												}
												
												if($cnt==$total_cnt & $okay==0){
													echo 'checked="checked"';
												}
												
												?>/>&nbsp;<label style="width:150px;" for="opt_<?php echo $x; ?>-<?php echo $optid; ?>" title="<?php echo $optname; ?>" class="theopt-name"><?php echo $optname; ?></label><span class="opt-pr-cur"><label><?php echo $pr_mu; ?></label></span>
                                                <?php } ?>
                                                
                                            </div>
                                       <?php
											}
									        
										}
										echo '</div>';
								 }
								 echo '</div>';
							 	}else{?>
								 	
                                    <div class="cart-opt" id="opt-holder-<?php echo $r['id'];?>">
                                    
									<?php 
									
									$theradiocount=0;
									
									while($opt = mysql_fetch_assoc($opt_q)){ 
										
										$theradiocount++;
										
										
											$qry=mysql_query("select id, name, price, if(order_by=0,'A',order_by) as theorderby from menu_options where menu_option_detail_id='".$opt['id']."' order by theorderby, id");
											
										?>
										<h5 class="h5<?php echo $opt['id']; ?>"><?php echo $opt['name']; ?></h5>
										<?php
										
											$cnt=0;
											$okay=0;
											$total_cnt=mysql_num_rows($qry);
											
											while(list($optid, $optname, $optprice) = mysql_fetch_array($qry)){
									
												$cnt++;
									
									?>
                                        <div class="opt-item">
                                        
                                        <?php if($opt['single_option']==0){ ?>
                                       		 <input type="checkbox" rel="st-<?php echo $r['id'];?>" alt="<?php echo $optprice;?>" id="opt_1-<?php echo $optid;?>" <?php echo checkOption($optid,1); ?>/>
                                        <?php }else{ 
										?>
                                        	<input type="radio" rel="st-<?php echo $r['id'];?>" alt="<?php echo $optprice;?>" id="opt_1-<?php echo $optid;?>" <?php 
											
											
												if(checkOption($optid,1)!=''){
													echo 'checked="checked"';
													$okay=1;
												}
												
												if($cnt==$total_cnt & $okay==0){
													echo 'checked="checked"';
												}
											
											?> name="opt-radio-<?php echo $theradiocount.'-'.$r['id']; ?>">
                                        <?php } ?>
                                        
                                       	    <label id="opt-name" class="theopt-name" for="opt_1-<?php echo $optid;?>" title="<?php echo $optname; ?>"><?php echo $optname;?></label>&nbsp;
                                        	<span class="opt-pr-cur">
                                            <label id="opt-pr"><?php echo ($optprice!=0)? number_format($optprice,0).' '.getCurrentCurrency() : '';?></label>
                                        	</span>
                                            
                                        </div>
                                 <?php }  //end while
								 
									} //end while
								 ?>
                                 
                                 </div>
                                 
							 	<?php }?>
                             
                             <?php }?>
        
        </td>
        <?php } ?>
        <td style="vertical-align:top;" class="request-msg-side"><font style="font-size: 20px; font-weight: bold;">Speciella önskemål</font><br /><textarea cols="8" class="requests-message"><?php echo $r['notes'];?></textarea> </td>
    </tr>
</table>
</div>
<div style="text-align:right;">
	<input type="button" value="Fortsätt" id="btn_skip" data-id="<?php echo $_POST['id']; ?>" data-placeholder="<?php echo $r['menu_id']; ?>" data-rel="<?php echo $_COOKIE['takeaway_id'];?>" data-title="<?php echo getMenuName($r['menu_id']);?>"/>
</div>

<script type="text/javascript">
jQuery(function(){
	
	var siteurl = jQuery('.takeaway_cart_wrap').attr('data-rel');

   
   jQuery('#btn_skip').click(function(){
	  
	  var addons='';
	  /*var name = jQuery('.req_dish').html();
	  var menu_id = jQuery('.req_dish').attr('data-id');
	  var uniq = jQuery('.req_dish').attr('data-rel');*/
	  
	  //var name = jQuery(this).attr('data-title');
	  var menu_id = jQuery(this).attr('data-placeholder');
	  var uniq = jQuery(this).attr('data-rel');
	  
	  var notes = jQuery('.requests-message').val();
	  var resid = jQuery(this).attr('data-id');
	  
	  jQuery('.cart-opt input[type=checkbox]:checked, .cart-opt input[type=radio]:checked').each(function(){
		var id=jQuery(this).attr('id'); 
		var price=jQuery(this).attr('alt');
		var name = jQuery('label[for='+id+']').attr('title');
		
		addons+=id+'*'+price+'*'+name+'^';
		
	  });
	  
	  addons = addons.substring(0, addons.length-1);
	  
	  jQuery('.cart_content').html('<center><img src="'+siteurl+'/images/loader.gif'+'"></center>');
	  jQuery.ajax({
		url: siteurl+"/save-options.php",
		type: 'POST',
		data: 'menu_id='+encodeURIComponent(menu_id)+'&uniq='+encodeURIComponent(uniq)+'&notes='+encodeURIComponent(notes)+'&res_detail_id='+encodeURIComponent(resid)+'&addons='+encodeURIComponent(addons),
		success: function(value){
			jQuery('.cart_content').load(siteurl+"/takeaway-cart.php");
			jQuery('.fader, #special_request').fadeOut();
		}
	 });
	  
   });
   
   
   jQuery('.remove-tillval').click(function(){
			
		var portion = jQuery(this).attr('data-rel');
		var portion_options = jQuery(this).attr('data-id');
		var id = jQuery(this).attr('data-title');
		
		jQuery('.'+portion+', #'+portion_options).remove();
		
		var type = 'update';
		if(jQuery('.cart-opt').length==1){
			type = 'delete';
		}
		
		jQuery.ajax({
			url: siteurl+"/update-quantity.php",
			type: 'POST',
			data: 'id='+encodeURIComponent(id)+'&type='+encodeURIComponent(type),
			success: function(value){
				jQuery('.cart_content').load(siteurl+"/takeaway-cart.php");
				
				if(jQuery('.cart-opt').length==1){
					jQuery('.fader, #special_request').fadeOut();
				}
			}
		 });	
			
	});
   
});
</script>