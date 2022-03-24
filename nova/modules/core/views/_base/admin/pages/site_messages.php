<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold"><a href="#" rel="facebox" myAction="add" myID="0" class="image"><?php echo img($images['add']) .' '. $label['add'];?></a></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['titles'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['messages'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['other'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($messages['title'])): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['name'];?></th>
						<th><?php echo $label['content'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($messages['title'] as $t): ?>
					<tr>
						<td class="col_30pct">
							<strong><?php echo $t['label'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo $label['key'] .' '. $t['key'];?>
							</span>
						</td>
						<td class="fontSmall"><?php echo $t['content'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $t['id'];?>" title="<?php echo $label['delete'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $t['id'];?>" title="<?php echo $label['edit'];?>"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_messages'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php if (isset($messages['message'])): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['name'];?></th>
						<th><?php echo $label['content'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($messages['message'] as $txt): ?>
					<tr>
						<td class="col_30pct">
							<strong><?php echo $txt['label'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo $label['key'] .' '. $txt['key'];?>
							</span>
						</td>
						<td class="fontSmall"><?php echo $txt['content'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="delete" myAction="delete" myID="<?php echo $txt['id'];?>" title="<?php echo $label['delete'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="edit" myAction="edit" myID="<?php echo $txt['id'];?>" title="<?php echo $label['edit'];?>"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_messages'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="three">
		<?php if (isset($messages['other'])): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['name'];?></th>
						<th><?php echo $label['content'];?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($messages['other'] as $other): ?>
					<tr>
						<td class="col_30pct">
							<strong><?php echo $other['label'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo $label['key'] .' '. $other['key'];?>
							</span>
						</td>
						<td class="fontSmall"><?php echo $other['content'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="delete" myAction="delete" myID="<?php echo $other['id'];?>" title="<?php echo $label['delete'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="edit" myAction="edit" myID="<?php echo $other['id'];?>" title="<?php echo $label['edit'];?>"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_messages'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
</div>