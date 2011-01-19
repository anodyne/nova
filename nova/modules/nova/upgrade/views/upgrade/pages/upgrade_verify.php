<p><?php echo __('verify.text');?></p>

<hr />

<?php if (isset($verify['failure'])): ?>
	<div class="flash-message flash-error">
		<?php foreach ($verify['failure'] as $key => $value): ?>
			<h1><?php echo $key;?></h1>
			<p><?php echo $value;?></p><br />
		<?php endforeach;?>
	</div>
<?php endif;?>

<?php if (isset($verify['info'])): ?>
	<div class="flash-message flash-info">
		<?php foreach ($verify['info'] as $key => $value): ?>
			<h1><?php echo $key;?></h1>
			<p><?php echo $value;?></p><br />
		<?php endforeach;?>
	</div>
<?php endif;?>

<?php if ( ! isset($verify['failure']) and ! isset($verify['info'])): ?>
	<div class="flash-message flash-success">
		<h1><?php echo __('verify.success_header');?></h1>
		<p><?php echo __('verify.success_text');?></p>
	</div>
<?php endif;?>