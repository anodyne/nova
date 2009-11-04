<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['page'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['history'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['comments'];?> (<?php echo $comment_count;?>)</span></a></li>
	</ul>
	
	<div id="one">
		<?php echo text_output($page['content'], 'p', '', FALSE);?>
		
		<p class="fontSmall gray bold">
			<?php echo ucfirst($label['created']) .' '. $label['by'] .' '. $page['created'] .' '. $label['on'] .' '. $page['created_date'];?>
		</p>
	</div>
	
	<div id="two">
		<?php echo text_output($label['history'], 'h2', 'page-subhead');?>
		
		<?php if (isset($history)): ?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($history as $h): ?>
					<tr>
						<td class="fontSmall">
							<?php if ($h['old_id'] === FALSE): ?>
								<?php echo $h['created'] .' '. $label['created'] .' '. anchor('wiki/view/draft/'. $h['draft'], text_output($h['title'], 'em')) .' '. $label['on'] .' '. $h['created_date'];?>
							<?php else: ?>
								<?php echo $h['created'] .' '. $label['reverted'] .' '. $label['to'] .' '. anchor('wiki/view/draft/'. $h['old_id'], text_output($h['title'], 'em')) .' '. $label['on'] .' '. $h['created_date'];?>
							<?php endif;?>
						</td>
						
						<?php if ($this->auth->is_logged_in()): ?>
							<td class="col_75 align_right">
								<?php echo anchor('wiki/view/draft/'. $h['draft'], img($images['view']), array('class' => 'image'));?>
								&nbsp;
								<a href="#" rel="facebox" myAction="revert" myPage="<?php echo $h['page'];?>" myDraft="<?php echo $h['draft'];?>" class="image"><?php echo img($images['revert']);?></a>
							</td>
						<?php endif;?>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['nohistory'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="three">
		<?php echo text_output($label['comments'], 'h2', 'page-subhead');?>
		
		<?php if (isset($comments)): ?>
			<div id="comments">
			<?php foreach ($comments as $c): ?>
				<p>
					<strong>
						<?php echo ucfirst($label['by']) . ' ' . $c['author'];?>
						<?php echo $label['on'] . ' ' . $c['date'];?>
					</strong><br /><br />
					<?php echo text_output($c['content'], '');?>
				</p>
			<?php endforeach;?>
			</div>
		<?php else: ?>
			<?php echo text_output($label['nocomments'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
</div>