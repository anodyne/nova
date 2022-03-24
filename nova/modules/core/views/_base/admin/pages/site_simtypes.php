<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" class="addtoggle image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<div class="addtype info-full hidden">
	<?php echo form_open('site/simtypes/add');?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['name']);?>
		</p>
		<p><?php echo form_button($buttons['add']);?></p>
	<?php echo form_close();?>
</div><br />

<hr size="1" /><br />

<?php if (isset($types)): ?>
	<?php echo form_open('site/simtypes/edit');?>
		<table class="zebra">
			<tbody>
			<?php foreach ($types as $t): ?>
				<tr height="60">
					<td class="col_50pct">
						<strong><?php echo $label['name'];?></strong><br />
						<?php echo form_input($t['name']);?>
					</td>
					<td class="align_right align_middle">
						<strong><?php echo form_label($label['delete'], $t['id'] .'_id');?>?</strong>
						<?php echo form_checkbox($t['delete']);?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<br />
		<?php echo form_button($buttons['update']);?>
	<?php echo form_close();?>
	</div>
<?php endif;?>