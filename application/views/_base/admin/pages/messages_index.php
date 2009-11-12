<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loading" class="loader">
	<?php echo img($loader);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<p>
		<?php echo anchor('messages/write', img($images['write']) .' '. $label['write'], array('class' => 'image bold'));?>
	</p>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['inbox'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['sent'];?></span></a></li>
		</ul>
		
		<div id="one" class="inbox">
			<?php if (!isset($inbox)): ?>
				<?php echo text_output($label['no_inbox'], 'h3', 'orange');?>
			<?php else: ?>
				<?php echo form_open('messages/index');?>
					<table class="zebra table100">
						<thead>
							<tr>
								<th><?php echo $label['from'];?></th>
								<th><?php echo $label['subject'];?></th>
								<th class="align_middle"><?php echo form_checkbox($inbox_check_all);?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($inbox as $item): ?>
							<tr>
								<td class="col_30pct"><strong><?php echo $item['author'];?></strong></td>
								<td>
									<strong><?php echo $item['unread'] .' '. anchor('messages/read/'. $item['id'], $item['subject']);?></strong><br />
									<span class="fontSmall gray"><?php echo $item['blurb'];?></span>
								</td>
								<td class="col_15 align_center"><?php echo form_checkbox($item['checkbox']);?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					
					<br /><?php echo form_button($button['inbox']);?>
					<div class="clear_right"></div>
				<?php echo form_close();?>
			<?php endif; ?>
		</div>
		
		<div id="two" class="outbox">
			<?php if (!isset($outbox)): ?>
				<?php echo text_output($label['no_outbox'], 'h3', 'orange');?>
			<?php else: ?>
				<?php echo form_open('messages/index/sent');?>
					<table class="zebra table100">
						<thead>
							<tr>
								<th><?php echo $label['to'];?></th>
								<th><?php echo $label['subject'];?></th>
								<th><?php echo form_checkbox($outbox_check_all);?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($outbox as $item): ?>
							<tr>
								<td class="col_40pct"><strong><?php echo $item['to'];?></strong></td>
								<td>
									<strong><?php echo anchor('messages/read/'. $item['id'], $item['subject']);?></strong><br />
									<span class="fontSmall gray"><?php echo $item['blurb'];?></span>
								</td>
								<td class="col_15 align_center"><?php echo form_checkbox($item['checkbox']);?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					
					<br /><?php echo form_button($button['outbox']);?>
					<div class="clear_right"></div>
				<?php echo form_close();?>
			<?php endif; ?>
		</div>
	</div>
</div>