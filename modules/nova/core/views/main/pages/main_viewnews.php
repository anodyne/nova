<?php if (isset($news) AND ($next !== NULL OR $prev !== NULL)): ?>
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
	<p class="fontSmall subtle">
		<strong><?php echo ucfirst(__("author"));?>:</strong> <?php echo $news->author_character->print_name();?><br />
		<?php echo Date::mdate($news->date);?>
		
		<?php if ($news->last_update !== NULL): ?>
			<br /><em><?php echo ucwords(__("Last Updated")).': '.Date::mdate($news->last_update);?></em>
		<?php endif;?>
	</p>
	
	<p class="fontSmall subtle">
		<strong><?php echo ucfirst(__("category"));?>:</strong> <?php echo $news->category->name;?>
		
		<?php if ( ! empty($news->tags)): ?>
			<br /><strong><?php echo ucfirst(__("tags"));?></strong> <?php echo $news->tags;?>
		<?php endif; ?>
	</p>
	
	<p>&nbsp;</p>
	
	<p><?php echo nl2br($news->content);?></p>
	
	<p>&nbsp;</p>
	
	<?php if ($next !== NULL OR $prev !== NULL): ?>
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
	
	<h4><?php echo count($news->comments);?> <?php echo (count($news->comments) == 1) ? ucfirst(__("comment")) : ucfirst(__("comments"));?></h4>
	
	<?php if (count($news->comments) > 0): ?>
		<?php foreach ($news->comments as $c): ?>
			<div class="comment">
				<div class="header">
					<div class="float-right subtle"><?php echo Date::mdate($c->date);?></div>
					<strong><?php echo $c->author_character->print_name();?></strong> <?php echo __('said');?>:
				</div>
				<div class="message">
					<p><?php echo nl2br($c->content);?></p>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif;?>
	
	<?php if ( ! Auth::is_logged_in()): ?>
		<div class="comment-add">
			<?php echo form::open('main/viewnews/'.$news->id);?>
				<?php echo form::textarea($inputs['content']['name'], $inputs['content']['value'], $inputs['content']['attr']);?>
				<br /><br />
				<div class="align-right"><?php echo form::button($buttons['submit']['name'], $buttons['submit']['value'], $buttons['submit']['attr']);?></div>
			<?php echo form::close();?>
		</div>
	<?php endif;?>
<?php endif;?>