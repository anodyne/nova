<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<div class="info-full">
	<?php echo text_output($label['depts'], 'h3');?>
	
	<?php if (isset($depts)): ?>
		<?php foreach ($depts as $d): ?>
			<p><strong><?php echo $d['name'];?></strong></p>
			
			<p class="fontSmall">
			<?php $count = count($d['items']);?>
			<?php $i = 1;?>
			<?php foreach ($d['items'] as $key => $value): ?>
				<nobr><?php echo anchor('manage/positions/'.$key, $value['name'], array('rel' => 'twipsy', 'title' => $value['desc']));?></nobr>
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

<br />

<?php if (isset($positions)): ?>
	<?php echo text_output($deptnames[$g_dept], 'h2');?>
	<div class="zebra">
	<?php echo form_open('manage/positions/'. $g_dept .'/edit');?>
	
		<?php foreach ($positions as $p): ?>
			<div id="<?php echo $p['id'];?>" class="padding_p5_0_p5_0">
				<table class="table100">
					<tr>
						<td><?php echo text_output($label['name'], 'span', 'bold');?></td>
						<td class="col_5"></td>
						<td><?php echo text_output($label['top_open'], 'span', 'bold');?></td>
						<td class="col_5"></td>
						<td class="col_30pct slider_control UITheme">
							<strong><?php echo $label['open'];?>:</strong>
							<span id="<?php echo $p['id'];?>_amount"><?php echo $p['open'];?></span>
							<input type="hidden" name="<?php echo $p['id'];?>_open" id="<?php echo $p['id'];?>_open" value="<?php echo $p['open'];?>" />
						</td>
						<td></td>
					</tr>
					<tr>
						<td><?php echo form_input($inputs['position'][$p['id']]['name']);?></td>
						<td class="col_5"></td>
						<td><?php echo form_dropdown($p['id'].'_top_open', $values['top_open'], $p['top_open']);?></td>
						<td class="col_5"></td>
						<td class="slider_control UITheme">
							<div id="<?php echo $p['id'];?>" class="slider"><?php echo $p['open'];?></div>
						</td>
						<td class="align_right align_middle">
							<strong><?php echo form_label($label['delete'], $p['id'] .'_id');?>?</strong>
							<?php echo form_checkbox($inputs['position'][$p['id']]['delete']);?>
						</td>
					</tr>
					<tr>
						<td colspan="6" class="align_right fontSmall">
							<button class="button-small" rel="popover" title="<?php echo $inputs['position'][$p['id']]['name']['value'];?>" data-content="<?php echo $additional[$p['id']];?>"><span class="text"><?php echo $label['more'];?></span></button>
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