<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loader" class="loader">
	<?php echo img($images['loading']);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['posts'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['logs'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['news'];?></span></a></li>
		</ul>
		
		<div id="one">
			<div class="subtabs">
				<ul>
					<li><a href="#four"><span><?php echo $label['activated'];?></span></a></li>
					<li><a href="#five"><span><?php echo $label['pending'];?></span></a></li>
				</ul>
				
				<div id="four"><?php echo $posts['activated'];?></div>
				<div id="five"><?php echo $posts['pending'];?></div>
			</div>
		</div>
		
		<div id="two">
			<div class="subtabs">
				<ul>
					<li><a href="#six"><span><?php echo $label['activated'];?></span></a></li>
					<li><a href="#seven"><span><?php echo $label['pending'];?></span></a></li>
				</ul>
				
				<div id="six"><?php echo $logs['activated'];?></div>
				<div id="seven"><?php echo $logs['pending'];?></div>
			</div>
		</div>
		
		<div id="three">
			<div class="subtabs">
				<ul>
					<li><a href="#eight"><span><?php echo $label['activated'];?></span></a></li>
					<li><a href="#nine"><span><?php echo $label['pending'];?></span></a></li>
				</ul>
				
				<div id="eight"><?php echo $news['activated'];?></div>
				<div id="nine"><?php echo $news['pending'];?></div>
			</div>
		</div>
	</div>
</div>