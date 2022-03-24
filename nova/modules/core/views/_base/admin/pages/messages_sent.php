<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="float_right">
	<br />
	<?php echo form_open('messages/search');?>
		<?php echo form_input($inputs['search']);?>&nbsp;<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?>
</div>
<?php echo text_output($header, 'h1', 'page-head');?>

<p class="fontMedium bold"><a href="<?php echo site_url('messages/index');?>"><?php echo $label['inbox'];?></a></p>

<div id="loading" class="loader">
	<?php echo img($loader).text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<p><?php echo anchor('messages/write', img($images['write']).$label['write'], array('class' => 'image bold'));?></p>
	
	<?php if ( ! isset($outbox)): ?>
		<?php echo text_output($label['no_outbox'], 'h3', 'orange');?>
	<?php else: ?>
		<?php echo form_open('messages/sent');?>
			
			<?php echo $outbox_pagination;?>
			
			<table class="table100 zebra">
				<thead>
					<tr>
						<th colspan="2"></th>
						<th class="col_30 align_middle"><?php echo form_checkbox($outbox_check_all);?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($outbox as $item): ?>
					<tr>
						<td class="col_5"></td>
						<td>
							<h4>
								<?php echo anchor('messages/read/'.$item['id'], $item['subject']);?>
								<a href="#" rel="popover" class="image" title="<?php echo $label['message_preview'];?>" data-content="<?php echo $item['preview'];?>"><?php echo img($images['preview']);?></a>
							</h4>
							<p class="gray fontSmall">
								<?php echo img($images['user']).$item['recipients'];?><br />
								<?php echo img($images['clock']).$item['date'];?>
							</p>
						</td>
						<td class="col_30 align_center"><?php echo form_checkbox($item['checkbox']);?></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
			
			<span class="float_right"><br /><?php echo form_button($button['outbox']);?></span>
			
			<?php echo $outbox_pagination;?>
			
			<div class="clear_right"></div>
		<?php echo form_close();?>
	<?php endif;?>
</div>