<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('archive/index', LARROW .' Back to Archive Index');?></p>

<?php if (isset($depts)): ?>
	<p><?php echo $depts;?></p>
	
	<br /><hr /><br />
<?php endif;?>

<?php if (isset($positions)): ?>
	<table class="table100">
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Open</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($positions as $p): ?>
			<tr>
				<td width="200" class="align_top bold fontMedium"><?php echo $p['name'];?></td>
				<td><?php echo $p['desc'];?></td>
				<td width="30" class="align_right"><?php echo $p['open'];?></td>
			</tr>
			<tr>
				<td colspan="3" height="20"></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>