<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>
<br />

<?php if (Auth::get_access_level('user/nominate') > 1): ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['nominate'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['nominatequeue'];?></span></a></li>
		</ul>
		
		<div id="one">
<?php endif;?>
			
			<?php if (isset($awards)): ?>
			<?php echo form_open('user/nominate');?>
				<p>
					<kbd><?php echo $label['award'];?></kbd>
					<?php echo form_dropdown('award', $awards, '', 'id="awards"');?>
					&nbsp;
					<span id="loading" class="hidden"><?php echo img($images['loading']);?></span>
					<p class="award-desc fontSmall gray"></p>
				</p>
				<p>
					<kbd><?php echo $label['character'];?></kbd>
					<span class="char-menu"><?php echo text_output($label['choose'], 'span', 'gray fontSmall italic');?></span>
				</p>
				<p>
					<kbd><?php echo $label['reason'];?></kbd>
					<?php echo form_textarea($inputs['reason']);?>
				</p><br />
				
				<p><?php echo form_button($buttons['submit']);?></p>
			<?php echo form_close();?>
			<?php else: ?>
				<?php echo text_output($label['noawards'], 'h3', 'orange');?>
			<?php endif;?>
		
<?php if (Auth::get_access_level('user/nominate') > 1): ?>
		</div>
		
		<div id="two">
			<?php if (isset($nominations)): ?>
				<br />
				<?php echo form_open('user/nominate/queue');?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th><?php echo $label['awardee'];?></th>
								<th><?php echo $label['reason'];?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($nominations as $n): ?>
							<tr>
								<td class="col_40pct">
									<strong><?php echo $n['awardee'];?></strong><br />
									<span class="fontSmall gray">
										<strong><?php echo $n['award'];?></strong><br />
										<?php echo $label['by'] .' '. $n['nominator'];?><br />
										<?php echo $label['on'] .' '. $n['date'];?>
									</span>
								</td>
								<td class="fontSmall"><?php echo $n['reason'];?></td>
								<td class="col_75 align_right">
									<a href="#" rel="facebox" myAction="reject" class="image" myID="<?php echo $n['id'];?>">
										<?php echo img($images['reject']);?>
									</a>
									&nbsp;
									<a href="#" rel="facebox" myAction="approve" class="image" myID="<?php echo $n['id'];?>">
										<?php echo img($images['accept']);?>
									</a>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php echo form_close();?>
			<?php else: ?>
				<?php echo text_output($label['nonominations'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>