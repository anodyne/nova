<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a href="<?php echo Uri::create('main/index');?>" class="brand"><?php echo $name;?></a>

			<div class="nav-collapse">
				<ul class="nav">

				</ul>
				<?php echo $navmain;?>
				<?php echo $user;?>
			</div>
		</div>
	</div>
</div>