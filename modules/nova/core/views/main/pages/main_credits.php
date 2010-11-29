<?php if ($edit === true): ?>
	<span class="float-right fontSmall">
		<?php echo html::anchor('site/messages', '[ '.ucfirst(__("edit")).' ]', array('class' => 'edit'));?>
	</span>
<?php endif;?>

<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $credits_perm;?></p>

<hr />

<p><?php echo $credits;?></p>