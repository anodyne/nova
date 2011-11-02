<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($users)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th class="align_right"><?php echo $label['timespan'];?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $u): ?>
			<tr>
				<td class="col_50pct">
					<strong><?php echo $u['name'];?></strong><br />
					<span class="fontTiny gray">
						<?php echo anchor('personnel/user/'. $u['id'], $label['bio_user']);?>
						|
						<?php echo anchor('personnel/character/'. $u['charid'], $label['bio_char']);?>
					</span>
				</td>
				<td class="align_right">
					<?php echo $u['timespan'];?><br />
					<?php echo text_output($u['join_date'], 'span', 'fontSmall gray');?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>