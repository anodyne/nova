<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold">
	<a href="#" class="addtoggle image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<div class="addcat info-full hidden">
	<?php echo form_open('wiki/managecategories/add');?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['name']);?>
		</p>
		
		<p>
			<kbd><?php echo $label['desc'];?></kbd>
			<?php echo form_textarea($inputs['desc']);?>
		</p>
		
		<p><?php echo form_button($buttons['add']);?></p>
	<?php echo form_close();?>
</div><br />

<?php if (isset($categories)): ?>
	<hr size="1" /><br />
	
	<table class="zebra table100">
		<thead>
			<tr>
				<th><?php echo $label['catname'];?></th>
				<th><?php echo $label['catdesc'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($categories as $c): ?>
			<tr>
				<td class="col_30pct"><?php echo text_output($c['name'], 'strong');?></td>
				<td class="fontSmall gray"><?php echo $c['desc'];?></td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" myAction="delete" myID="<?php echo $c['id'];?>" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" rel="facebox" myAction="edit" myID="<?php echo $c['id'];?>" class="image"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['nocats'], 'h3', 'orange');?>
<?php endif;?>