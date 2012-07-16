<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Anodyne Productions">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>
		
		<link rel="stylesheet" href="<?php echo Uri::base(false);?>nova/modules/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo Uri::base(false);?>nova/modules/setup/views/design/style.css">
	</head>
	<body>
		<?php echo $layout;?>

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<?php echo $javascript;?>
		
		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</body>
</html>