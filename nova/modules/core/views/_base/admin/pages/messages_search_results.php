<h1 class="page-head"><?php echo $header;?></h1>

<p class="fontMedium bold"><a href="<?php echo site_url('messages/index');?>"><?php echo $label['back'];?></a></p>

<?php if (isset($results)): ?>

<?php else: ?>
	<h3 class="orange"><?php echo $label['no_results'];?></h3>
	
	<p>&nbsp;</p>
	
	<?php echo form_open('messages/search');?>
		<?php echo form_input($inputs['search']);?>
		&nbsp;
		<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?>
<?php endif;?>