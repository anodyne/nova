<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" class="addtoggle image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<div class="addcat info-full hidden">
	<?php echo form_open('manage/newscats/add');?>
		<table>
			<tbody>
				<tr>
					<td class="align_bottom">
						<strong><?php echo $label['name'];?></strong><br />
						<?php echo form_input($inputs['name']);?>
					</td>
					<td class="col_30"></td>
					<td class="align_bottom"><?php echo form_button($buttons['add']);?></td>
				</tr>
			</tbody>
		</table>
	<?php echo form_close();?>
</div><br />

<hr size="1" /><br />

<?php if (isset($categories)): ?>
	<?php echo form_open('manage/newscats/edit');?>
		<table class="zebra table100">
			<tbody>
			<?php foreach ($categories as $c): ?>
				<tr height="60">
					<td class="col_50pct">
						<strong><?php echo $label['name'];?></strong><br />
						<?php echo form_input($c['name']);?>
					</td>
					<td>
						<strong><?php echo $label['display'];?></strong><br />
						<?php echo form_dropdown($c['id'] .'_display', $values['display'], $c['display']);?>
					</td>
					<td class="align_right align_middle">
						<strong><?php echo form_label($label['delete'], $c['id'] .'_id');?>?</strong>
						<?php echo form_checkbox($c['delete']);?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<br />
		<?php echo form_button($buttons['update']);?>
	<?php echo form_close();?>
<?php endif;?>