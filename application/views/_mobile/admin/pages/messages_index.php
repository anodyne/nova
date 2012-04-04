<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1');?>

<div id="loaded">
	<div data-role="controlgroup">
		<?php echo anchor('messages/write', $label['write'], array('data-role' => 'button'));?>
		<a href="#" id="mark_read" data-user="<?php echo $this->session->userdata('userid');?>" data-role="button"><?php echo $label['mark_read'];?></a>
	</div>
	
	<?php if ( ! isset($inbox)): ?>
		<?php echo text_output($label['no_inbox'], 'h3', 'orange');?>
	<?php else: ?>
		<br/>
		<ul data-role="listview" data-theme="c">
		<?php foreach ($inbox as $item): ?>
			<li <?php if ($item['unread']): echo 'data-theme="e"'; endif;?>>
				<a href="<?php echo site_url('messages/read/'.$item['id']);?>">
					<h3 class="ul-li-heading"><?php echo $item['subject'];?></h3>
					<p class="ul-li-desc"><?php echo $item['author'];?></p>
					<p class="ul-li-desc"><?php echo $item['date'];?></p>
				</a>
			</li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
</div>