<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>
<p><?php echo anchor('sim/awards', $label['back'], array('class' => 'bold font110'));?></p>

<p><?php echo img($img);?></p>
<?php echo text_output($desc);?>
<p>
	<strong><?php echo $label['category'];?></strong> <?php echo $cat;?><br />
	<strong><?php echo $label['awarded'];?></strong> <?php echo $awardees_count;?>
</p>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php endif; ?>

<?php if (isset($awardees)): ?>
	<table class="table100 zebra" cellspacing="0" cellpadding="6" border="0">
		
	<?php foreach ($awardees as $v): ?>
		<tr>
			<td class="col_30pct">
				<strong><?php echo $v['person'];?></strong><br />
				<span class="fontSmall"><?php echo $v['date'];?></span>
			</td>
			<td><?php echo text_output($v['reason'], '');?></td>
		</tr>
	<?php endforeach; ?>
	
	</table>
<?php endif; ?>