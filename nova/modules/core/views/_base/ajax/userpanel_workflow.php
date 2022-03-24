<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<a href="#" id="userpanel" class="panel-trigger">
	<span><div class="ui-icon ui-icon-triangle-1-s float_right"></div><?php echo $label['dashboard'];?></span>
</a>

<ul id="panel-handle-left">
	<li>
		<a href="<?php echo site_url('messages/index');?>">
			<span>
				<?php echo img($icons[$unreadpm_icon]);?> <?php echo $label['inbox'];?>
				<?php if ($unreadpm > 0): ?>
					(<?php echo $unreadpm;?>)
				<?php endif;?>
			</span>
		</a>
	</li>
	
	<li>
		<a href="<?php echo site_url('write/index');?>">
			<span><?php echo img($icons[$unreadjp_icon]);?> <?php echo $label['writing'];?>
				<?php if ($saveditems > 0): ?>
					(<?php echo $saveditems;?>)
				<?php endif;?>
			</span>
		</a>
	</li>
</ul>