<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['docked_current'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['docked_previous'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($docked['active'])): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['name'];?></th>
						<th><?php echo $label['gm_name'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($docked['active'] as $d): ?>
					<tr>
						<td>
							<?php echo text_output($d['sim_name'], 'span', 'bold fontMedium');?><br />
							<a href="<?php echo $d['sim_url'];?>" target="_blank"><?php echo $d['sim_url'];?></a>
						</td>
						<td><?php echo $d['gm_name'];?></td>
						<td class="col_75 align_right">
							<?php echo anchor('sim/docked/'. $d['id'], img($images['view']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['norequests'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="two">
		<?php if (isset($docked['inactive'])): ?>
			
		<?php else: ?>
			<?php echo text_output($label['norequests'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
</div>