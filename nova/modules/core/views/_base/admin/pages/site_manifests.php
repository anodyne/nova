<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['sitemanifests'], 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p><strong><a href="#" id="add" class="image"><?php echo img($images['add']).' '.$label['add'];?></a></strong></p>
<p><strong><?php echo anchor('site/manifests/assign', img($images['assign']).' '.$label['assign'], array('class' => 'image'));?></strong></p>

<div id="add-panel" class="info-full hidden">
	<?php echo form_open('site/manifests/add');?>
		<p>
			<kbd><?php echo $label['manifest_name'];?></kbd>
			<?php echo form_input($inputs['name']);?>
		</p>
		<p>
			<kbd><?php echo $label['manifest_order'];?></kbd>
			<?php echo form_input($inputs['order']);?>
		</p>
		<p>
			<kbd><?php echo $label['manifest_desc'];?></kbd>
			<?php echo form_textarea($inputs['desc']);?>
		</p>
		<p>
			<kbd><?php echo $label['manifest_header'];?></kbd>
			<?php echo form_textarea($inputs['header']);?>
		</p>
		<p>
			<kbd><?php echo $label['manifest_view'];?></kbd>
			<?php echo form_dropdown('manifest_view', $values['manifest'], '');?>
		</p>
		<p>
			<kbd><?php echo $label['manifest_metadata'];?></kbd>
			<?php echo form_input($inputs['metadata']);?>
			<p class="gray fontSmall"><?php echo $label['metadata_explain'];?></p>
		</p>
		<p><?php echo form_button($inputs['button']);?></p>
	<?php echo form_close();?>
</div>

<hr />

<?php if (isset($manifests)): ?>
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($manifests as $m): ?>
			<tr>
				<td>
					<strong>
						<?php if ($m['display'] == 'n'): ?>
							<span class="fontSmall red">[ <?php echo $label['off'];?> ]</span>
						<?php endif;?>
						<?php echo $m['name'];?>
					</strong><br />
					<span class="fontSmall gray">
						<?php echo $m['desc'];?>
					</span>
				</td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $m['id'];?>"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" rel="facebox" class="image" myAction="edit" myID="<?php echo $m['id'];?>"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>

<?php endif;?>