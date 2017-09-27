<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h1 class="page-head"><?php echo $header;?></h1>

<p class="fontMedium bold"><a href="<?php echo site_url('messages/index');?>"><?php echo $label['back'];?></a></p>

<div id="loading" class="loader">
	<?php echo img($loader).text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<?php if (isset($results)): ?>
		<?php if ($results['received_count'] > 0 && $results['sent_count'] > 0) : ?>
			<div id="tabs">
				<ul>
					<li><a href="#one"><span><?php echo $label['received'] . ': ' . $results['received_count'];?></span></a></li>
					<li><a href="#two"><span><?php echo $label['sent'] . ': ' . $results['sent_count'];?></span></a></li>
				</ul>
				
				<div id="one">
					<table class="table100 zebra">
						<thead>
							<tr>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($results['received'] as $item): ?>
							<tr>
								<td>
									<h4>
										<?php echo anchor('messages/read/'. $item['id'], $item['subject']);?>
										<a href="#" rel="popover" class="image" title="<?php echo $label['message_preview'];?>" data-content="<?php echo $item['preview'];?>"><?php echo img($images['preview']);?></a>
									</h4>
									<p class="gray fontSmall">
										<?php echo img($images['user']).$item['author'];?><br />
										<?php echo img($images['clock']).$item['date'];?>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div id="two">
					<table class="table100 zebra">
						<thead>
							<tr>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($results['sent'] as $item): ?>
							<tr>
								<td>
									<h4>
										<?php echo anchor('messages/read/'. $item['id'], $item['subject']);?>
										<a href="#" rel="popover" class="image" title="<?php echo $label['message_preview'];?>" data-content="<?php echo $item['preview'];?>"><?php echo img($images['preview']);?></a>
									</h4>
									<p class="gray fontSmall">
										<?php echo img($images['user']).$item['author'];?><br />
										<?php echo img($images['clock']).$item['date'];?>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		<?php elseif ($results['received_count'] > 0) : ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['received'] . ': ' . $results['received_count'];?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($results['received'] as $item): ?>
					<tr>
						<td>
							<h4>
								<?php echo anchor('messages/read/'. $item['id'], $item['subject']);?>
								<a href="#" rel="popover" class="image" title="<?php echo $label['message_preview'];?>" data-content="<?php echo $item['preview'];?>"><?php echo img($images['preview']);?></a>
							</h4>
							<p class="gray fontSmall">
								<?php echo img($images['user']).$item['author'];?><br />
								<?php echo img($images['clock']).$item['date'];?>
							</p>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php elseif ($results['sent_count'] > 0) : ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['sent'] . ': ' . $results['sent_count'];?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($results['sent'] as $item): ?>
					<tr>
						<td>
							<h4>
								<?php echo anchor('messages/read/'. $item['id'], $item['subject']);?>
								<a href="#" rel="popover" class="image" title="<?php echo $label['message_preview'];?>" data-content="<?php echo $item['preview'];?>"><?php echo img($images['preview']);?></a>
							</h4>
							<p class="gray fontSmall">
								<?php echo img($images['user']).$item['author'];?><br />
								<?php echo img($images['clock']).$item['date'];?>
							</p>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php endif ?>
	<?php else: ?>
		<h3 class="orange"><?php echo $label['no_results'];?></h3>
		
		<p>&nbsp;</p>
		
		<?php echo form_open('messages/search');?>
			<?php echo form_input($inputs['search']);?>
			&nbsp;
			<?php echo form_button($inputs['submit']);?>
		<?php echo form_close();?>
	<?php endif;?>
</div>