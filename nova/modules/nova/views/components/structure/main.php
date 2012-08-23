<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo $meta_desc;?>">
		<meta name="keywords" content="<?php echo $meta_keywords;?>">
		<meta name="author" content="<?php echo $meta_author;?>">
		
		<?php if (isset($_redirect)): echo $_redirect; endif;?>

		<!-- Bootstrap Toolkit -->
		<link rel="stylesheet" href="<?php echo Uri::base(false);?>nova/modules/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo Uri::base(false);?>nova/modules/assets/css/icomoon.css">
		
		<!-- Nova's base styles and any user-defined styles -->
		<?php if (is_file(APPPATH.'views/'.$skin.'/design/style.css')): ?>
			<link rel="stylesheet" href="<?php echo Uri::base(false);?>app/views/<?php echo $skin;?>/design/style.css">
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo Uri::base(false);?>nova/modules/nova/views/design/style.css">
			
			<?php if (is_file(APPPATH.'views/'.$skin.'/design/custom.css')): ?>
				<link rel="stylesheet" href="<?php echo Uri::base(false);?>app/views/<?php echo $skin;?>/design/custom.css">
			<?php endif;?>
		<?php endif;?>
	</head>
	<body>
		<?php echo $layout;?>

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Nova's core Javascript -->
		<?php include_once NOVAPATH.'nova/views/components/js/core/main_js.php';?>

		<!-- Nova's per-page Javascript -->
		<?php echo $javascript;?>
	</body>
</html>