<div class="navbar">
	<div class="navbar-inner">
		<a class="brand" href="<?php echo Uri::create('main/index');?>"><?php echo $name;?></a>

		<ul class="nav">
		<?php foreach ($items as $item): ?>
			<?php

			// get the url segments
			$segments = explode('/', $item->url);

			// get the first item of the URI
			$first = strtolower(\Uri::segment(1));

			// class output
			$activeOutput = ($segments[0] == $first) ? ' class="active"' : false;

			// figure out what should be shown
			$targetOutput = ($item->url_target == 'offsite') ? ' target="_blank"' : false;

			?><li<?php echo $activeOutput;?>><a href="<?php echo Uri::create($item->url);?>"<?php echo $targetOutput;?>><?php echo $item->name;?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
</div>