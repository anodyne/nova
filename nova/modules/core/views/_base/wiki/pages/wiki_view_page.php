<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($page)): ?>
	<?php echo text_output($header, 'h1', 'page-head');?>
	
	<?php if (Auth::is_logged_in()): ?>
		<div class="wiki-subnav">
			<div class="subnav-options"></div>
			<div class="subnav-content">
				<ul>
					<li>
						<a href="#" myAction="comment" rel="facebox" myID="<?php echo $id;?>" class="image">
							<?php echo img($images['comment']) .' '. $label['addcomment'];?>
						</a>
					</li>
					
					<?php if ($edit): ?>
						<li>
							<?php echo anchor('wiki/page/'.$id.'/edit', img($images['edit']).' '.$label['edit'], array('class' => 'image'));?>
						</li>
					<?php endif;?>
				</ul>
			</div>
		</div>
	<?php endif;?>
	
	<?php if (Auth::is_logged_in()): ?>
		<div id="tabs">
			<ul>
				<li><a href="#one"><?php echo img($images['page']);?></a></li>
				
				<?php if ($access): ?>
					<li><a href="#two"><?php echo img($images['history']);?></a></li>
				<?php endif;?>
				
				<li><a href="#three"><?php echo img($images['comments']);?></a></li>
			</ul>
	<?php endif;?>
	
			<div id="one">
				<p class="fontSmall gray bold">
					<?php echo ucfirst($label['created']) .' '. $label['by'] .' '. $page['created'] .' '. $label['on'] .' '. $page['created_date'];?>
				</p>
				
				<?php echo text_output($page['content'], 'p', '', FALSE);?>
				
				<br />
				<div class="info-full fontSmall">
					<p><?php echo text_output($label['categories'], 'strong') .' '. $page['categories'];?></p>
				</div>
			</div>
			
	<?php if (Auth::is_logged_in()): ?>
		<?php if ($access): ?>
			<div id="two">
				<?php echo text_output($label['history'], 'h2', 'page-subhead');?>
				
				<?php if (isset($history)): ?>
					<table class="table100 zebra">
						<tbody>
						<?php foreach ($history as $h): ?>
							<tr>
								<td>
									<?php if ($h['old_id'] === FALSE): ?>
										<?php echo $h['created'] .' '. $label['created'] .' '. anchor('wiki/view/draft/'. $h['draft'], text_output($h['title'], 'strong')) .' '. $label['on'] .' '. $h['created_date'];?>
									<?php else: ?>
										<?php echo $h['created'] .' '. $label['reverted'] .' '. $label['to'] .' '. anchor('wiki/view/draft/'. $h['old_id'], text_output($h['title'], 'strong')) .' '. $label['on'] .' '. $h['created_date'];?>
									<?php endif;?>
									
									<?php if (!empty($h['changes'])): ?>
										<br />
										<?php echo text_output($h['changes'], 'em', 'fontSmall gray');?>
									<?php endif;?>
								</td>
								
								<?php if (Auth::is_logged_in()): ?>
									<td class="col_75 align_right">
										<?php echo anchor('wiki/view/draft/'. $h['draft'], img($images['view']), array('class' => 'image'));?>
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
		<?php endif;?>
		
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
	<?php endif;?>
<?php else: ?>
	<?php echo text_output($label['nopage'], 'h1', 'red');?>
<?php endif;?>