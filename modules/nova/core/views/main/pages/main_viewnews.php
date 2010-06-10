<?php if (isset($news) && ($next !== NULL || $prev !== NULL)): ?>
	<div class="float-right">
		<?php if ($prev !== NULL): ?>
			<?php echo html::anchor('main/viewnews/'.$prev, html::image($images['prev']['src'], $images['prev']['attr']), array('class' => 'image'));?>
		<?php endif; ?>
		
		<?php if ($next !== NULL): ?>
			<?php echo html::anchor('main/viewnews/'.$next, html::image($images['next']['src'], $images['next']['attr']), array('class' => 'image'));?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<h1 class="page-head<?php echo $headerclass;?>"><?php echo $header;?></h1>

<?php echo $message;?>

<?php if (isset($news)): ?>
	<p class="fontSmall info">
		<strong>
			<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($news->date);?>
			<?php //echo __('word.by').' '.Utility::print_character_name($news->author_character);?>
		</strong>
		
		<?php if ($news->last_update !== NULL): ?>
			<br /><?php echo ucfirst(__('action.edited')).' '.Utility::print_date($news->last_update);?><br />
		<?php endif;?>
	</p>
	
	<p class="fontSmall info">
		<strong><?php echo ucfirst(__('label.category')).':</strong> '.$news->category->name;?>
		
		<?php if (!empty($news->tags)): ?>
			<br /><strong><?php echo ucfirst(__('label.tags')).':</strong> '. $news->tags;?>
		<?php endif; ?>
	</p>
	
	<p>&nbsp;</p>
	
	<p><?php echo nl2br($news->content);?></p>
	
	<p>&nbsp;</p>
	
	<?php if ($next !== NULL || $prev !== NULL): ?>
		<div class="float-right">
			<?php if ($prev !== NULL): ?>
				<?php echo html::anchor('main/viewnews/'.$prev, html::image($images['prev']['src'], $images['prev']['attr']), array('class' => 'image'));?>
			<?php endif; ?>
			
			<?php if ($next !== NULL): ?>
				<?php echo html::anchor('main/viewnews/'.$next, html::image($images['next']['src'], $images['next']['attr']), array('class' => 'image'));?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<p><?php echo html::anchor('feed/news', html::image($images['rss']['src'], $images['rss']['attr'], FALSE), array('class' => 'image'));?></p>
	
	<h4><?php echo count($comments);?> <?php echo (count($comments) == 1) ? ucfirst(__('label.comment')) : ucfirst(__('label.comments'));?></h4>
	
	<?php if (count($comments) > 0): ?>
		<?php foreach ($comments as $c): ?>
			<div class="comment">
				<div class="header">
					<div class="float-right subtle"><?php echo Utility::print_date($c->date);?></div>
					<strong><?php //echo Utility::print_character_name($c->author_character);?></strong> <?php echo __('action.said');?>:
				</div>
				<div class="message">
					<p><?php echo nl2br($c->content);?></p>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif;?>
	
	<?php if (!Auth::is_logged_in()): ?>
		<div class="comment-add">
			<?php echo form::open('main/viewnews/'.$news->id);?>
				<?php echo form::textarea($inputs['content']['name'], $inputs['content']['value'], $inputs['content']['attr']);?>
				<br /><br />
				<div class="align-right"><?php echo form::button($buttons['submit']['name'], $buttons['submit']['value'], $buttons['submit']['attr']);?></div>
			<?php echo form::close();?>
		</div>
	<?php endif;?>
<?php endif;?>