<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium">
	<a href="#" class="addtoggle image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<div class="addcat info-full hidden">
	<?php echo form_open('wiki/managecategories/add');?>
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

<?php if (isset($categories)): ?>
	<hr size="1" /><br />
	
	<table class="zebra table100">
		<thead>
			<tr>
				<th><?php echo $label['catname'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($categories as $c): ?>
			<tr>
				<td><?php echo text_output($c['name'], 'strong');?></td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" myAction="delete" myID="<?php echo $c['id'];?>" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" rel="facebox" myAction="edit" myID="<?php echo $c['id'];?>" class="image"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>