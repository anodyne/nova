<?php if (isset($news) && ($next !== FALSE || $prev !== FALSE)): ?>
	<div class="float-right">
		<?php if ($prev !== FALSE): ?>
			<?php echo html::anchor('main/viewnews/'.$prev, html::image($images['prev']), array('class' => 'image'));?>
		<?php endif; ?>
		
		<?php if ($next !== FALSE): ?>
			<?php echo html::anchor('main/viewnews/'.$next, html::image($images['next']), array('class' => 'image'));?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<h1 class="page-head<?php echo $headerclass;?>"><?php echo $header;?></h1>

<?php echo $message;?>

<?php if (isset($news)): ?>
	<p class="fontSmall info">
		<strong>
			<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($news->news_date);?>
			<?php echo __('word.by').' '.Utility::print_character_name($news->news_author_character);?>
		</strong>
		
		<?php if ($news->news_last_update > 0): ?>
			<br /><?php echo ucfirst(__('action.edited')).' '.Utility::print_date($news->news_last_update);?><br />
		<?php endif;?>
	</p>
	
	<p class="fontSmall info">
		<strong><?php echo ucfirst(__('word.category')).':</strong> '.$news->newscat_name;?>
		
		<?php if (!empty($news->news_tags)): ?>
			<br /><strong><?php echo ucfirst(__('word.tags')).':</strong> '. $news->news_tags;?>
		<?php endif; ?>
	</p>
	
	<p>&nbsp;</p>
	
	<p><?php echo nl2br($news->news_content);?></p>
	
	<p>&nbsp;</p>
	
	<?php if ($next !== FALSE || $prev !== FALSE): ?>
		<div class="float-right">
			<?php if ($prev !== FALSE): ?>
				<?php echo html::anchor('main/viewnews/'.$prev, html::image($images['prev']), array('class' => 'image'));?>
			<?php endif; ?>
			
			<?php if ($next !== FALSE): ?>
				<?php echo html::anchor('main/viewnews/'.$next, html::image($images['next']), array('class' => 'image'));?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<p><?php echo html::anchor('feed/news', html::image($images['rss']), array('class' => 'image'));?></p>
	
	<h4><?php echo count($comments);?> <?php echo (count($comments) == 1) ? ucfirst(__('word.comment')) : ucfirst(__('word.comments'));?></h4>
	
	<?php if (count($comments) > 0): ?>
		<?php foreach ($comments as $c): ?>
			<div class="comment">
				<div class="header">
					<div class="float-right subtle"><?php echo Utility::print_date($c->ncomment_date);?></div>
					<strong><?php echo Utility::print_character_name($c->ncomment_author_character);?></strong> <?php echo __('action.said');?>:
				</div>
				<div class="message">
					<p><?php echo nl2br($c->ncomment_content);?></p>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif;?>
	
	<?php if (Auth::is_logged_in()): ?>
		<div class="comment-add">
			<?php echo form::open('main/viewnews/'.$news->news_id);?>
				<?php echo form::textarea($inputs['content']);?>
				<br /><br />
				<div class="align-right"><?php echo form::button($buttons['submit']);?></div>
			</form>
		</div>
	<?php endif;?>
<?php endif;?>