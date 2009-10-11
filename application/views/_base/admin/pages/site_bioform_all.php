<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/biotabs', img($images['tabs']) .' '. $label['biotabs'], array('class' => 'image'));?><br />
	<?php echo anchor('site/biosections', img($images['sections']) .' '. $label['biosections'], array('class' => 'image'));?>
	<br /><br />
	<a href="#" rel="facebox" class="image" myAction="add">
		<?php echo img($images['add_field']) .' '. $label['biofield'];?>
	</a>
</p>
<br />

<?php if (isset($join)): ?>
	<?php foreach ($join as $a): ?>
		<?php if (isset($a['fields'])): ?>
			<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
			
			<table class="table100 zebra">
				<tbody>
					
				<?php foreach ($a['fields'] as $f): ?>
					<tr>
						<td class="cell-label"><?php echo $f['field_label'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $f['input'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" myAction="delete" myID="<?php echo $f['id'];?>" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('site/bioform/edit/'. $f['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table><br />
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>