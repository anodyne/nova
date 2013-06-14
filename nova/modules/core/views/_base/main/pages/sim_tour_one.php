<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	a.image { display: inline-block; }
	a.image span { padding: 0px; display: inline-block; }
	a.image span img { margin: 0px; padding: 0px; }
</style>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/tour', $label['back'], array('class' => 'bold'));?></p>

<?php echo text_output($label['summary'], 'h2', 'page-subhead');?>
<?php echo text_output($summary);?>

<?php if (isset($images['main_img'])): ?>
	<div id="gallery">
		<?php echo text_output($label['opengallery'], 'p', 'fontSmall gray bold');?>
		<a href="<?php echo base_url() . $images['main_img']['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($images['main_img']);?></a>
		
		<div class="hidden">
			<?php if (count($images['image_array']) > 0): ?>
				<?php foreach ($images['image_array'] as $image): ?>
					<a href="<?php echo base_url() . $image['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($image);?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div><br />
	</div>
<?php endif; ?>

<?php if (isset($fields)): ?>
	<?php echo text_output($label['info'], 'h2', 'page-subhead');?>
	<table class="table100 zebra">
		<?php foreach ($fields as $field): ?>
			<?php if ( ! empty($field['data'])): ?>
				<tr>
					<td class="cell-label"><?php echo $field['label'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo text_output($field['data'], '');?></td>
				</tr>
			<?php endif;?>
		<?php endforeach; ?>
	</table>
<?php endif; ?>