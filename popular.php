<?php

ini_set('display_errors', 0);

require('config.php');

$result = mysql_query("SELECT * FROM " . DB_TABLE . " ORDER BY referrals DESC LIMIT 0 , 200") or die(mysql_error());


?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://www.iconsdb.com/icons/preview/black/bear-2-m.png">

    <title>Popular URLs on xno.li</title>

    <!-- Bootstrap core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
		<h2 class="form-signin-heading">Most popular URLs<img src="http://www.iconsdb.com/icons/preview/black/bear-l.png" alt="bear"></h2>
		<div class="list-group">
<?php
while($row = mysql_fetch_array($result)) {
$prefix = "http://";
if(substr($row['long_url'], 0, strlen("https"))=="https") $prefix = "https://";
?>
			<a href="<?php echo $row['long_url']; ?>" class="list-group-item" target="_blank">
				<span class="badge<?php if($prefix == "https://") echo " badge-https" ?>"><?php echo $row['referrals']; ?></span> 
				<?php
				echo substr($row['long_url'], strlen($prefix), 80);
				if((strlen($row['long_url']) - strlen($prefix)) > 80) echo "...";
				?></a>

<?php
}
?>
		</div>
    </div> <!-- /container -->
	
<!-- IE mobile viewport fix -->
<script>
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
        document.createTextNode(
            "@-ms-viewport{width:auto!important}"
        )
    );
    document.getElementsByTagName("head")[0].
        appendChild(msViewportStyle);
}
</script>

  </body>
</html>