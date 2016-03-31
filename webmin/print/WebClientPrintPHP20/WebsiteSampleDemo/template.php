
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>



    <title><?php echo $title; ?></title>
    

    <!--[if lt IE 9]>
    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap.min.css" rel="stylesheet" />   	
    <!--[if IE 6]>    
    	<link href="https://raw.github.com/empowering-communities/Bootstrap-IE6/master/ie6.min.css" rel="stylesheet">
    <![endif]-->
    
     <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 15px 0;
      }
      
      <?php echo isset($style)?$style:''; ?>
      
      </style>

      <?php echo isset($head)?$head:''; ?>
      
</head>
<body>
    

    <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
            <li><a href="Home.php"><i class="icon-home"></i></a></li>
            <li><a href="DemoPrintCommands.php">Print Commands</a></li>
            <li><a href="DemoPrintFile.php">Print Files</a></li>
        </ul>
        <h3 class="muted"><a href="http://www.neodynamic.com/products/printing/raw-data/php/" target="_blank">WebClientPrint 2.0 for PHP</a></h3>
        <div class="label"><small><em>Cross-browser Client-side Printing Solution for Windows, Linux &amp; Mac</em></small></div>
        <br />
      </div>
      <div class="pull-right">
        <a class="btn btn-primary" href="http://www.neodynamic.com/products/printing/raw-data/php/download/" target="_blank"><i class="icon-download-alt icon-white"></i> Download SDK for PHP</a>
      </div>
      <hr />
          

    <div>
        <?php echo isset($content)?$content:''; ?>
      
    </div>

    
    <div class="footer">
        <br /><br /><br /><br /><hr />
        <p><a href="http://www.neodynamic.com/products/printing/raw-data/php/" target="_blank">WebClientPrint for PHP</a>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <i class="icon-user"></i> <a href="http://www.neodynamic.com/support" target="_blank">Contact Tech Support</a>
        </p>
        <p>&copy; Copyright 2013 - Neodynamic SRL<br />All rights reserved.</p>
    </div>

    </div> <!-- /container -->

    


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            if ($.browser.msie && parseInt($.browser.version, 10) === 6) { 
                $('.row div[class^="span"]:last-child').addClass("last-child"); 
                $('[class*="span"]').addClass("margin-left-20"); 
                $('[class*="span"][class*="offset"]').removeClass('margin-left-20'); 
                $(':button[class="btn"], :reset[class="btn"], :submit[class="btn"], input[type="button"]').addClass("button-reset"); 
                $(":checkbox").addClass("input-checkbox"); 
                $('[class^="icon-"], [class*=" icon-"]').addClass("icon-sprite"); 
                $(".pagination li:first-child a").addClass("pagination-first-child"); 
            }
        });
    </script>

    <?php echo isset($script)?$script:''; ?>
      
</body>
</html>
