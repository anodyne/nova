<h1 class="page-head"><?php echo $header;?></h1>

<div id="tabs">
	<ul>
		<li><a href="#general"><?php echo ucwords(__('general'));?></a></li>
		<li><a href="#prefs"><?php echo ucwords(__('preferences'));?></a></li>
		<li><a href="#display"><?php echo ucwords(__('display :options', array(':options' => __('options'))));?></a></li>
		
		<?php if (Auth::get_access_level() == 2): ?>
			<li><a href="#admin"><?php echo ucwords(__('admin :options', array(':options' => __('options'))));?></a></li>
		<?php endif;?>
	</ul>
	
	<div id="general">
		<?php echo form::open();?>
			<p>
				<kbd><?php echo ucfirst(__('name'));?></kbd>
				<?php echo form::input('name', $user->name);?>
			</p>
			<p>
				<kbd><?php echo ucwords(__('email address'));?></kbd>
				<?php echo form::input('email', $user->email, array('type' => 'email'));?>
			</p>
		<?php echo form::close();?>
	</div>
	
	<div id="prefs">
		Preferences
	</div>
	
	<div id="display">
		Display preferences
	</div>
	
	<?php if (Auth::get_access_level() == 2): ?>
		<div id="admin">
			Admin options
		</div>
	<?php endif;?>
</div>