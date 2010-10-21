<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" rel="facebox" class="image"><?php echo img($images['add']) .' '. $label['add_dept'];?></a>
</p><br />

<?php if (isset($depts)): ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['assigned'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['unassigned'];?></span></a></li>
		</ul>
		
		<div id="one">
			<div class="zebra">
			<?php echo form_open('manage/depts/edit/assigned');?>
			
				<?php foreach ($depts['assigned'] as $d): ?>
					<div id="<?php echo $d['id'];?>" class="padding_p5_0_p5_0">
						<table class="table100">
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['name'];?></strong><br />
									<?php echo form_input($inputs[$d['id']]['name']);?>
								</td>
								<td class="col_5"></td>
								<td class="align_top" colspan="2" rowspan="3">
									<strong><?php echo $label['desc'];?></strong><br />
									<?php echo form_textarea($inputs[$d['id']]['desc']);?>
								</td>
							</tr>
							
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['parent'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_parent', $parent, $d['parent']);?>
								</td>
								<td class="col_5"></td>
							</tr>
							
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['manifest'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_manifest', $manifest, $d['manifest']);?>
								</td>
								<td class="col_5"></td>
							</tr>
							
							<tr>
								<td class="align_top">
									<strong><?php echo $label['type'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_type', $values[$d['id']]['type'], $d['type']);?>
								</td>
								<td class="align_top">
									<strong><?php echo $label['order'];?></strong><br />
								<?php echo form_input($inputs[$d['id']]['order']);?>
								</td>
								<td class="align_top">
									<strong><?php echo $label['display'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_display', $values[$d['id']]['display'], $d['display']);?>
								</td>
								<td class="col_5"></td>
								<td class="align_right align_middle UITheme">
									<button action="duplicate" class="button-small" id="<?php echo $d['id'];?>">
										<span class="ui-icon ui-icon-copy float_right" style="margin-top:-1px"></span>
										<span class="text"><?php echo $label['duplicate'];?></span>&nbsp;
									</button>
									
									&nbsp;
									
									<button action="delete" class="button-small" id="<?php echo $d['id'];?>">
										<span class="ui-icon ui-icon-close float_right" style="margin-top:-1px"></span>
										<span class="text"><?php echo $label['delete'];?></span>&nbsp;
									</button>
								</td>
								<td class="col_5"></td>
							</tr>
						</table>
					</div>
				<?php endforeach;?>
				
				<br />
				<?php echo form_button($buttons['update']);?>
			<?php echo form_close();?>
			</div>
		</div>
		
		<div id="two">
			<div class="zebra">
			<?php echo form_open('manage/depts/edit/unassigned');?>
			
				<?php foreach ($depts['unassigned'] as $d): ?>
					<div id="<?php echo $d['id'];?>" class="padding_p5_0_p5_0">
						<table class="table100">
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['name'];?></strong><br />
									<?php echo form_input($inputs[$d['id']]['name']);?>
								</td>
								<td class="col_5"></td>
								<td class="align_top" colspan="2" rowspan="3">
									<strong><?php echo $label['desc'];?></strong><br />
									<?php echo form_textarea($inputs[$d['id']]['desc']);?>
								</td>
							</tr>
							
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['parent'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_parent', $parent, $d['parent']);?>
								</td>
								<td class="col_5"></td>
							</tr>
							
							<tr>
								<td class="col_40pct" colspan="3">
									<strong><?php echo $label['manifest'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_manifest', $manifest, $d['manifest']);?>
								</td>
								<td class="col_5"></td>
							</tr>
							
							<tr>
								<td class="align_top">
									<strong><?php echo $label['type'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_type', $values[$d['id']]['type'], $d['type']);?>
								</td>
								<td class="align_top">
									<strong><?php echo $label['order'];?></strong><br />
								<?php echo form_input($inputs[$d['id']]['order']);?>
								</td>
								<td class="align_top">
									<strong><?php echo $label['display'];?></strong><br />
									<?php echo form_dropdown($d['id'] .'_display', $values[$d['id']]['display'], $d['display']);?>
								</td>
								<td class="col_5"></td>
								<td class="align_right align_middle UITheme">
									<button action="duplicate" class="button-small" id="<?php echo $d['id'];?>">
										<span class="ui-icon ui-icon-copy float_right" style="margin-top:-1px"></span>
										<span class="text"><?php echo $label['duplicate'];?></span>&nbsp;
									</button>
									
									&nbsp;
									
									<button action="delete" class="button-small" id="<?php echo $d['id'];?>">
										<span class="ui-icon ui-icon-close float_right" style="margin-top:-1px"></span>
										<span class="text"><?php echo $label['delete'];?></span>&nbsp;
									</button>
								</td>
								<td class="col_5"></td>
							</tr>
						</table>
					</div>
				<?php endforeach;?>
				
				<br />
				<?php echo form_button($buttons['update']);?>
			<?php echo form_close();?>
			</div>
		</div>
	</div>
<?php endif;?>