<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('archive/index', LARROW .' Back to Archive Index');?></p>

<?php if (isset($depts)): ?>
	<table class="table100">
		<tbody>
		<?php foreach ($depts as $d): ?>
			<tr>
				<td width="200" class="align_top bold fontMedium"><?php echo $d['name'];?></td>
				<td><?php echo $d['desc'];?></td>
			</tr>
			<tr>
				<td colspan="2" height="20"></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>