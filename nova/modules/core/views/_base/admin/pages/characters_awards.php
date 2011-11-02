<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (!isset($characters)): ?>
	<?php echo text_output($name, 'h2', 'page-subhead');?>

	<p class="bold"><?php echo anchor('characters/awards', $label['back']);?></p>

	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['give'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['all'];?></span></a></li>
		</ul>

		<div id="one">
			<?php if (isset($awards)): ?>
				<?php echo form_open('characters/awards');?>
					<p>
						<kbd><?php echo $label['award'];?></kbd>
						<?php echo form_dropdown('award', $awards, '', 'id="awards"');?>
						&nbsp;
						<span id="loading" class="hidden"><?php echo img($images['loading']);?></span>
						<p class="award-desc fontSmall gray"></p>
					</p>
					
					<p>
						<kbd><?php echo $label['reason'];?></kbd>
						<?php echo form_textarea($inputs['reason']);?>
					</p><br />
					
					<p>
						<?php echo form_hidden('id', $id);?>
						<?php echo form_button($buttons['submit']);?>
					</p>
				<?php echo form_close();?>
			<?php else: ?>
				<?php echo text_output($label['no_awards_to_give'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="two">
			<?php if (isset($user)): ?>
				<?php echo text_output($label['ooc'], 'h3');?>
				<table class="table100 zebra">
					<tbody>
					<?php foreach ($user['awards'] as $u): ?>
						<tr id="<?php echo $u['id'];?>">
							<td class="col_75 align_center"><?php echo img($u['image']);?></td>
							<td>
								<strong><?php echo $u['award'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['given'] .' '. $u['date'];?><br />
									<?php echo text_output($u['reason'], '');?>
								</span>
							</td>
							<td class="col_75 align_right">
								<a href="#" myID="<?php echo $u['id'];?>" class="remove image"><?php echo img($images['remove']);?></a>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php endif;?>
			
			<?php if (isset($character)): ?>
				<?php echo text_output($label['ic'], 'h3');?>
				<table class="table100 zebra">
					<tbody>
					<?php foreach ($character['awards'] as $c): ?>
						<tr id="<?php echo $c['id'];?>">
							<td class="col_75 align_center"><?php echo img($c['image']);?></td>
							<td>
								<strong><?php echo $c['award'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['given'] .' '. $c['date'];?><br />
									<?php echo text_output($c['reason'], '');?>
								</span>
							</td>
							<td class="col_75 align_right">
								<a href="#" myID="<?php echo $c['id'];?>" class="remove image"><?php echo img($images['remove']);?></a>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php else: ?>
				<?php echo text_output($label['no_awards'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
<?php else: ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['active'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['npc'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['inactive'];?></span></a></li>
		</ul>

		<div id="one">
			<?php echo text_output($label['active'], 'h2');?>
			<?php if (isset($characters['active'])): ?>
				<ul class="margin1">
				<?php foreach ($characters['active'] as $i): ?>
					<li><strong><?php echo anchor('characters/awards/'. $i['id'], $i['name']);?></strong></li>
				<?php endforeach;?>
				</ul>
			<?php else: ?>
				<?php echo text_output($label['nochars'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="two">
			<?php echo text_output($label['npc'], 'h2');?>
			<?php if (isset($characters['npc'])): ?>
				<ul class="margin1">
				<?php foreach ($characters['npc'] as $i): ?>
					<li><strong><?php echo anchor('characters/awards/'. $i['id'], $i['name']);?></strong></li>
				<?php endforeach;?>
				</ul>
			<?php else: ?>
				<?php echo text_output($label['nochars'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="three">
			<?php echo text_output($label['inactive'], 'h2');?>
			<?php if (isset($characters['inactive'])): ?>
				<ul class="margin1">
				<?php foreach ($characters['inactive'] as $i): ?>
					<li><strong><?php echo anchor('characters/awards/'. $i['id'], $i['name']);?></strong></li>
				<?php endforeach;?>
				</ul>
			<?php else: ?>
				<?php echo text_output($label['nochars'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>