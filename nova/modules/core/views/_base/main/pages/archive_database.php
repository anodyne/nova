<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($entries)): ?>
	<p class="bold fontMedium"><?php echo anchor('archive/index', LARROW .' Back to Archive Index');?></p>
	
	<table class="table100 zebra">
		<thead>
			<tr>
				<th class="col_40pct">Title</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($entries as $key => $value): ?>
			<tr>
				<td class="bold">
					<?php if ($value['type'] == 'entry'): ?>
						<?php echo anchor('archive/database/'. $key, $value['title']);?>
					<?php else: ?>
						<?php echo $value['title'];?>
					<?php endif;?>
				</td>
				<td class="fontSmall"><?php echo $value['desc'];?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php elseif (isset($entry)): ?>
	<p class="bold fontMedium"><?php echo anchor('archive/database', LARROW .' Back to Database Entries');?></p>
	
	<p><strong>Description:</strong> <?php echo text_output($entry['desc'], '');?></p>
	
	<hr />
	
	<?php echo $entry['content'];?>
<?php endif;?>