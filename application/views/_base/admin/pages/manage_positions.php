<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<div class="info-full">
	<?php echo text_output($label['depts'], 'h4');?>
	
	<?php if (isset($depts)): ?>
		<?php foreach ($depts as $d): ?>
			<p><strong><?php echo $d['name'];?></strong></p>
			
			<p class="fontSmall">
			<?php $count = count($d['items']);?>
			<?php $i = 1;?>
			<?php foreach ($d['items'] as $key => $value): ?>
				<?php echo anchor('manage/positions/'. $key, $value);?>
				<?php if ($i != $count): ?>
					&middot;
				<?php endif;?>
				<?php ++$i;?>
			<?php endforeach;?>
			</p>
		<?php endforeach;?>
	<?php endif;?>
</div>

<p class="bold">
	<a href="#" rel="facebox" myID="<?php echo $g_dept;?>" class="image">
		<?php echo img($images['add']) .' '. $label['add_position'];?>
	</a>
</p>

<br /> <hr /> <br />

<?php if (isset($positions)): ?>
	<?php echo text_output($deptnames[$g_dept], 'h2');?>
	<div class="zebra">
	<?php echo form_open('manage/positions/'. $g_dept .'/edit');?>
	
		<?php foreach ($positions as $p): ?>
			<div id="<?php echo $p['id'];?>" class="padding_p5_0_p5_0">
				<table class="table100">
					<tr>
						<td class="col_40pct"><?php echo text_output($label['name'], 'span', 'bold');?></td>
						<td class="col_5"></td>
						<td class="col_40pct slider_control UITheme">
							<strong><?php echo $label['open'];?>:</strong>
							<span id="<?php echo $p['id'];?>_amount"><?php echo $p['open'];?></span>
							<input type="hidden" name="<?php echo $p['id'];?>_open" id="<?php echo $p['id'];?>_open" value="<?php echo $p['open'];?>" />
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="col_40pct"><?php echo form_input($inputs['position'][$p['id']]['name']);?></td>
						<td class="col_5"></td>
						<td class="col_40pct slider_control UITheme">
							<div id="<?php echo $p['id'];?>" class="slider"><?php echo $p['open'];?></div>
						</td>
						<td class="align_right align_middle">
							<strong><?php echo form_label($label['delete'], $p['id'] .'_id');?>?</strong>
							<?php echo form_checkbox($inputs['position'][$p['id']]['delete']);?></td>
					</tr>
				</table>
				
				<div id="tr_<?php echo $p['id'];?>" class="hidden">
					<table class="table100">
						<tr>
							<td class="align_top">
								<strong><?php echo $label['order'];?></strong><br />
								<?php echo form_input($inputs['position'][$p['id']]['order']);?>
							</td>
							<td class="align_top">
								<strong><?php echo $label['display'];?></strong><br />
								<?php echo form_dropdown($p['id'] .'_display', $values['position'][$p['id']]['display'], $p['display']);?>
							</td>
							<td class="align_top">
								<strong><?php echo $label['type'];?></strong><br />
								<?php echo form_dropdown($p['id'] .'_type', $values['position'][$p['id']]['type'], $p['type']);?>
							</td>
							<td class="col_5" rowspan="2"></td>
							<td class="align_top" rowspan="2">
								<strong><?php echo $label['desc'];?></strong><br />
								<?php echo form_textarea($inputs['position'][$p['id']]['desc']);?>
							</td>
							<td class="col_5" rowspan="2"></td>
						</tr>
						<tr>
							<td colspan="2">
								<strong><?php echo $label['dept'];?></strong><br />
								<?php echo form_dropdown($p['id'] .'_dept', $depts, $p['dept']);?>
							</td>
						</tr>
					</table>
				</div>
				
				<table class="table100"
					<tr>
						<td class="align_right fontSmall UITheme">
							<button class="button-small" curAction="more" id="<?php echo $p['id'];?>">
								<span class="ui-icon ui-icon-triangle-1-s float_right"></span>
								<span class="text"><?php echo $label['more'];?></span>&nbsp;
							</button>
						</td>
					</tr>
				</table>
			</div>
		<?php endforeach;?>
		
		<br />
		<?php echo form_button($buttons['update']);?>
	<?php echo form_close();?>
	</div>
<?php endif;?>