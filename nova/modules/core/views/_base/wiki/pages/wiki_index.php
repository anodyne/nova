<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<p class="float_right"><a href="#" id="search-trigger" class="image"><?php echo img($images['search']);?></a></p>
<?php echo text_output($header, 'h1', 'page-head');?>

<div id="search-panel" class="info-full hidden">
	<?php echo form_open('search/results');?>
		<p>
			<kbd><?php echo $label['search_in'];?></kbd>
			<?php echo form_dropdown('component', $component);?>
		</p>
		<p>
			<kbd><?php echo $label['search_for'];?></kbd>
			<?php echo form_input($inputs['search']);?>
		</p><br />
		<p>
			<?php echo form_hidden('type', 'wiki');?>
			<?php echo form_button($inputs['submit']);?>
		</p>
	<?php echo form_close();?>
</div>

<?php echo $syspage;?>