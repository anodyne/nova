<p class="fontMedium"><?php echo ___('verify.intro');?></p>

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
		<h1><?php echo ___("You're All Set!");?></h1>
		<p><?php echo ___('verify.success');?></p>
	</div>
<?php endif;?>