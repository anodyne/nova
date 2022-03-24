<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
	.post_info { width: auto; margin: 0 0 2em 0; border-top: none; }
	.group-info { margin: 8px 0 0 0; }
	h2 { margin: 0; padding: 3px 5px; }
</style>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/missions', $label['missions'], array('class' => 'bold'));?></p><br />

<?php if (isset($groups)): ?>
	<div class="UITheme">
		<?php foreach ($groups as $g): ?>
			<h2 class="ui-widget-header ui-corner-top"><?php echo $g['name'];?></h2>
			<div class="post_info ui-corner-bottom">
				<div class="group-info">
					<strong class="gray fontSmall">
						<?php echo $label['count_posts'].' '.$g['count']['posts'];?>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $label['count_groups'].' '.$g['count']['groups'];?>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $label['count_missions'].' '.$g['count']['missions'];?>
					</strong>
				</div><br />
				
				<?php echo text_output($g['desc']);?>
				
				<?php if (isset($g['missions']) or isset($g['subgroups'])): ?>
					<hr />
				<?php endif;?>
				
				<?php if (isset($g['missions'])): ?>
					<h3 class="page-subhead"><?php echo $label['included'];?></h3>
					<div class="indent-left">
						<ul>
						<?php foreach ($g['missions'] as $m): ?>
							<li>
								<strong class="fontMedium"><?php echo anchor('sim/missions/id/'.$m['id'], $m['title']);?></strong><br />
								<p class="fontSmall gray">
									<?php if (isset($m['group'])): ?>
										<strong><?php echo $label['group'];?>:</strong> <?php echo $m['group'];?><br />
									<?php endif;?>
									<strong><?php echo $label['count_posts'].'</strong> '.$m['count'];?><br />
									<?php echo text_output($m['desc'], '');?>
								</p>
							</li>
						<?php endforeach;?>
						</ul><br />
					</div>
				<?php endif;?>
				
				<?php if (isset($g['subgroups'])): ?>
					<h3 class="page-subhead"><?php echo $label['included_groups'];?></h3>
					<div class="indent-left">
						<ul>
						<?php foreach ($g['subgroups'] as $s): ?>
							<li><strong class="fontMedium"><?php echo anchor('sim/missions/group/'.$s['id'], $s['name']);?></strong></li>
						<?php endforeach;?>
						</ul><br />
					</div>
				<?php endif;?>
			</div>
		<?php endforeach;?>
	</div>
<?php else: ?>
	<?php echo text_output($label['nogroups'], 'h3', 'orange');?>
<?php endif;?>