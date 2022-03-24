<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="loader" class="align_center">
	<?php echo img($images['loading']);?><br />
	<?php echo text_output($label['loading'], 'span', 'fontSmall bold gray');?>
</div>

<div id="loaded" class="hidden">
	<?php echo text_output($header, 'h1', 'page-head');?>
	
	<p class="bold">
		<?php echo anchor('characters/create', img($images['add']) .' '. $label['create'], array('class' => 'image'));?>
	</p>
	
	<?php if ($count > 0): ?>
		<?php foreach ($characters as $c): ?>
			<?php if (isset($c['chars'])): ?>
				<?php if (isset($c['dept'])): ?>
					<?php echo text_output($c['dept'], 'h3', 'page-subhead');?>
				<?php endif;?>
				<table class="table100 zebra">
					<tbody>
					<?php foreach ($c['chars'] as $i): ?>
						<tr>
							<td>
								<strong><?php echo $i['name'];?></strong><br />
								
								<span class="fontSmall gray">
									<?php echo $i['position_1'];?>
									
									<?php if (!empty($i['position_2'])): ?>
										&amp; <?php echo $i['position_2'];?>
									<?php endif;?>
								</span>
							</td>
							<td class="col_150 align_right">
								<?php if (!empty($i['pid']) && $levelcheck['account'] == 2): ?>
									<?php echo anchor('user/account/'. $i['pid'], img($images['account']), array('class' => 'image'));?>
									&nbsp;
								<?php endif;?>
								
								<?php echo anchor('personnel/character/'. $i['id'], img($images['view']), array('class' => 'image'));?>
								&nbsp;
								<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" class="image">
									<?php echo img($images['delete']);?>
								</a>
								
								<?php if ($levelcheck['bio'] == 3): ?>
									&nbsp;
									<?php echo anchor('characters/bio/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php endif;?>
		<?php endforeach;?>
	<?php else: ?>
		<?php echo text_output($label['noactive'], 'h3', 'orange');?>
	<?php endif;?>
</div>