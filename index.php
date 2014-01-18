<?php require('config.php'); ?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://www.iconsdb.com/icons/preview/black/bear-2-m.png">

    <title><?php echo $_SERVER['HTTP_HOST']; ?> URL-shortener</title>

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

      <form class="form-signin" id="shortener">
        <h2 class="form-signin-heading"><img src="http://www.iconsdb.com/icons/preview/black/bear-2-l.png" alt="bear"> Paste URL here</h2>
        <input id="longurl" type="text" class="form-control" placeholder="URL" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Shorten</button>
      </form>

	  <div class="well">
		<h4>To preview a link use <?php echo BASE_HREF; ?><em>preview</em>/<strong>id</strong> instead of <?php echo BASE_HREF; ?><strong>id</strong></h4>
		<a href="<?php echo BASE_HREF; ?>preview/1" target="_blank"><?php echo BASE_HREF; ?>preview/1</a>
		
		<br/><br/><h4>To programmatically shorten URLs with PHP use the following code</h4>	
		$shorturl = file_get_contents( '<?php echo BASE_HREF; ?>shorten/' . urlencode('http://mylongurl.com') );
		
		<br/><br/><h4>To programmatically get the number of referrals with PHP use the following code</h4>
		$referrals = file_get_contents( '<?php echo BASE_HREF; ?>referrals/' . $shorturl );
	  </div>
    </div> <!-- /container -->

<!-- jQuery 1.3.2 -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<!-- Shorten URL JS -->
<script type="text/javascript">
$(function () {
	$('#shortener').submit(function () {
		$.ajax({data: {longurl: $('#longurl').val()}, url: 'shorten.php', complete: function (XMLHttpRequest, textStatus) {
			$('#longurl').val(XMLHttpRequest.responseText);
		}});
		return false;
	});
});
</script>

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