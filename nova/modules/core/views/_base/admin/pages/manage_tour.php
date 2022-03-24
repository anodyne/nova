<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if (Auth::check_access('site/tourform', false)): ?>
	<p class="bold">
		<?php echo anchor('site/tourform', img($images['form']) .' '. $label['form'], array('class' => 'image'));?>
	</p>
<?php endif;?>

<p class="bold">
	<?php echo anchor('manage/tour/add', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<?php if (isset($items)): ?>
	<br />
	<?php foreach ($items as $key => $value): ?>
		<table class="table100 zebra-even">
			<tbody>
				<tr>
					<td colspan="3"><?php echo text_output($value, 'span', 'fontLarge bold page-subhead');?></td>
				</tr>
				
				<?php if (isset($tour[$key])): ?>
					<?php foreach ($tour[$key] as $t): ?>
						<tr>
							<td height="35" class="col_15"></td>
							<td>
								<strong><?php echo $t['name'];?></strong><br />
								<span class="gray fontSmall">
									<strong><?php echo $label['summary'];?></strong>
									<?php echo $t['summary'];?>
								</span>
							</td>
							<td class="col_75 align_right">
								<a href="#" myAction="delete" myID="<?php echo $t['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
								&nbsp;
								<?php echo anchor('manage/tour/edit/'. $t['id'], img($images['edit']), array('class' => 'image'));?>
							</td>
						</tr>
					<?php endforeach;?>
				<?php else: ?>
					<tr>
						<td height="35" class="col_15"></td>
						<td colspan="2"><?php echo text_output($label['no_tour'], 'span', 'fontMedium bold orange');?></td>
					</tr>
				<?php endif;?>
			</tbody>
		</table><br />
	<?php endforeach;?>
	<?php echo form_open().form_close();?>
<?php else: ?>
	<?php echo text_output($label['no_tour'], 'h3', 'orange');?>
<?php endif; ?>