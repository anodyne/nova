<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('archive/index', LARROW .' Back to Archive Index');?></p>

<?php if (isset($decks)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th>Deck</th>
				<th>Deck Content</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($decks as $key => $value): ?>
			<tr>
				<td class="bold"><?php echo $key;?></td>
				<td><?php echo $value;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output('No deck listing found', 'h3', 'orange');?>
<?php endif;?>