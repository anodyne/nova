<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" class="addtoggle"><?php echo $label['add'];?></a>
</p>

<div class="addtype info-full hidden">
	<?php echo form_open('site/simtypes/add');?>
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