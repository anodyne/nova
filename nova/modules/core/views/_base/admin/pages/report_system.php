<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="loader" class="align_center">
	<?php echo img($images['loading']);?><br />
	<?php echo text_output($label['loading'], 'span', 'fontSmall bold gray');?>
</div>

<div id="loaded" class="hidden">
	<?php echo text_output($header, 'h1', 'page-head');?>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['versions'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['systeminfo'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['components'];?></span></a></li>
		</ul>
		
		<div id="one" class="UITheme">
			<?php echo text_output($label['versions'], 'h2', 'page-subhead');?>
			<?php if (count($versions) > 1): ?>
				<div id="accordion">
					<?php foreach ($versions as $key => $value): ?>
						<h2><a href="#"><?php echo $key;?></a></h2>
						<div>
							<?php foreach ($value as $v): ?>
								<h4><?php echo $v['version'];?></h4>
								<?php echo $v['changes'];?>
							<?php endforeach;?>
						</div>
					<?php endforeach;?>
				</div>
			<?php else: ?>
				<span id="accordion">
				<?php foreach ($versions as $key => $value): ?>
					<?php foreach ($value as $v): ?>
						<h4><?php echo $v['version'];?></h4>
						<?php echo $v['changes'];?>
					<?php endforeach;?>
				<?php endforeach;?>
				</span>
			<?php endif;?>
		</div>
		
		<div id="two">
			<?php echo text_output($label['systeminfo'], 'h2', 'page-subhead');?>
			<p>
				<strong><?php echo $label['url'];?></strong> <?php echo base_url();?><br /><br />
				
				<strong><?php echo $label['version_files'];?></strong> <?php echo $version['files'];?><br />
				<strong><?php echo $label['version_db'];?></strong> <?php echo $version['database'];?><br />
				<strong><?php echo $label['version_ci'];?></strong> <?php echo $version['ci'];?>
			</p>
		</div>
		
		<div id="three">
			<?php echo text_output($label['components'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($comp as $c): ?>
					<tr>
						<td class="bold col_40pct">
							<a href="<?php echo $c['url'];?>" target="_blank">
								<?php echo $c['name'] .' '. $c['version'];?>
							</a>
						</td>
						<td class="fontSmall"><?php echo text_output($c['desc'], '');?></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>