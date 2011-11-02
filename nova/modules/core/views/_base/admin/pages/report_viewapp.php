<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($app)): ?>
	<table class="table100 zebra">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['date'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['date'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['pname'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['user'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['email'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['email'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['cname'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['character'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['position'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['position'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['action'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $app['action'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['message'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo text_output($app['message'], '');?></td>
			</tr>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['none'], 'h3', 'orange');?>
<?php endif;?>