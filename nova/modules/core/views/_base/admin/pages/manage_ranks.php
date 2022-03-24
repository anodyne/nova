<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<div class="info-full">
	<?php if (isset($allranks)): ?>
		<?php echo text_output($label['sets'] . '&nbsp;&nbsp;', 'p', 'float_left bold gray');?>
		<p>
			<?php foreach ($allranks as $a => $b): ?>
				<?php echo anchor('manage/ranks/'. $a, img($b), array('class' => 'image'));?> &nbsp;
			<?php endforeach;?>
		</p>
	<?php endif;?>
	
	<?php if (isset($allclasses)): ?>
		<?php echo text_output($label['classes'] . '&nbsp;&nbsp;', 'p', 'float_left bold gray');?>
		<p>
			<?php foreach ($allclasses as $k => $v): ?>
				<?php echo anchor('manage/ranks/'. $set .'/'. $k, img($v), array('class' => 'image'));?> &nbsp;
			<?php endforeach;?>
		</p>
	<?php endif;?>
</div>

<p class="bold">
	<a href="#" rel="facebox" myClass="<?php echo $class;?>" mySet="<?php echo $set;?>" class="image">
		<?php echo img($images['add']) .' '. $label['addrank'];?>
	</a>
</p>

<br /><hr /><br />

<?php if (isset($ranks)): ?>
	<div class="zebra">
	<?php echo form_open('manage/ranks/'. $set .'/'. $class .'/edit');?>
	
		<?php foreach ($ranks as $r): ?>
			<div id="<?php echo $r['id'];?>" class="padding_p5_0_p5_0">
				<table class="table100">
					<tr>
						<td class="col_150"><?php echo img($r['img']);?></td>
						<td>
							<?php echo text_output($label['name'], 'span', 'bold');?><br />
							<?php echo form_input($r['name']);?>
						</td>
						<td class="col_150">
							<?php echo text_output($label['image'], 'span', 'bold');?><br />
							<?php echo form_input($r['image']) . text_output($ext, 'span', 'fontSmall gray');?>
						</td>
						<td class="align_right align_middle col_100">
							<strong><?php echo form_label($label['delete'], $r['id'] .'_id');?>?</strong>
							<?php echo form_checkbox($r['delete']);?>
						</td>
					</tr>
				</table>
				
				<div id="tr_<?php echo $r['id'];?>" class="hidden">
					<table class="table100">
						<tr>
							<td class="col_150"></td>
							<td class="align_top">
								<?php echo text_output($label['order'], 'span', 'bold');?><br />
								<?php echo form_input($r['order']);?>
							</td>
							<td class="align_top">
								<?php echo text_output($label['class'], 'span', 'bold');?><br />
								<?php echo form_input($r['class']);?>
							</td>
							<td class="align_top">
								<?php echo text_output($label['display'], 'span', 'bold');?><br />
								<?php echo form_dropdown($r['id'] .'_display', $values['display'], $r['display']);?>
							</td>
							<td class="align_top col_150">
								<?php echo text_output($label['shortname'], 'span', 'bold');?><br />
								<?php echo form_input($r['shortname']);?>
							</td>
							<td class="col_100"></td>
						</tr>
					</table>
				</div>
				
				<table class="table100">
					<tr>
						<td class="align_right fontSmall UITheme">
							<button class="button-small" curAction="more" id="<?php echo $r['id'];?>">
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