<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/docked', $label['back'], array('class' => 'bold'));?></p><br />

<?php if (isset($docked)): ?>
	<table class="table100 zebra">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo $docked['sim_name'];?><br />
					<span class="fontSmall">
						<a href="<?php echo $docked['sim_url'];?>" target="_blank"><?php echo $docked['sim_url'];?></a>
					</span>
				</td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['gm_name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $docked['gm_name'];?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['received'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $docked['date'];?></td>
			</tr>
		</tbody>
	</table><br />
	
	<?php if (isset($sections)): ?>
		<?php foreach ($sections as $section): ?>
			<?php echo text_output($section['title'], 'h3', 'page-subhead');?>
			
			<?php if (isset($section['fields'])): ?>
			<table class="table100 zebra" cellpadding="3">
				<tbody>
				<?php foreach ($section['fields'] as $field): ?>
					<?php if ( ! empty($field['data'])): ?>
						<tr>
							<td class="cell-label"><?php echo $field['field'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo $field['data'];?></td>
						</tr>
					<?php endif;?>
				<?php endforeach; ?>
				</tbody>
			</table><br />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
<?php else: ?>
	<?php echo text_output($label['nosim'], 'h3', 'orange');?>
<?php endif;?>