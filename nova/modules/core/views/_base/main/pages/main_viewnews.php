<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if ($private == 'y' and Auth::is_logged_in() === FALSE): ?>
	<?php echo text_output($label['error_pagetitle'], 'h1', 'red');?>
	<?php echo text_output($label['error_private_news'], 'h4');?>
<?php else: ?>
	<?php if (isset($next) || isset($prev)): ?>
		<div class="float_right">
			<?php if (isset($prev)): ?>
				<?php echo anchor('main/viewnews/'. $prev, img($images['prev']), array('class' => 'image'));?>
			<?php endif; ?>
			
			<?php if (isset($next)): ?>
				<?php echo anchor('main/viewnews/'. $next, img($images['next']), array('class' => 'image'));?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<?php echo text_output($title, 'h1', 'page-head');?>

	<?php if ($status != "activated"): ?>
		<p class="bold orange"><?php echo $label['nonactivenews'];?></p>
	<?php endif;?>
	
	<p><?php echo link_to_if($edit_valid, 'manage/news/edit/'. $id, $label['edit'], array('class' => 'edit fontSmall bold'));?></p>
	
	<p class="fontSmall bold gray">
		<?php echo $label['posted'] .' '. $date .' '. $label['by'] .' '. $author;?>
		
		<?php if (isset($update)): ?>
			<br />
			<?php echo $label['edited'] .' '. $label['on'] .' '. $update;?><br />
		<?php endif;?>
	</p>
	
	<?php echo text_output($content);?>
	
	<p>&nbsp;</p>
	
	<?php if (isset($next) || isset($prev)): ?>
		<div class="float_right">
			<?php if (isset($prev)): ?>
				<?php echo anchor('main/viewnews/'. $prev, img($images['prev']), array('class' => 'image'));?>
			<?php endif; ?>
			
			<?php if (isset($next)): ?>
				<?php echo anchor('main/viewnews/'. $next, img($images['next']), array('class' => 'image'));?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<p class="fontSmall gray">
		<strong><?php echo $label['category'] .'</strong> '. $category;?>
		
		<?php if (isset($tags)): ?>
			<br /><strong><?php echo $label['tags'] .'</strong> '. $tags;?>
		<?php endif; ?>
	</p>
	
	<p><?php echo anchor('feed/news', img($images['feed']), array('class' => 'image'));?></p>
	
	<?php if (Auth::is_logged_in()): ?>
		<p class="bold">
			<a href="#" id="add_comment" rel="facebox" myID="<?php echo $news_id;?>" class="image">
				<?php echo img($images['comment']) .' '. $label['addcomment'];?>
			</a>
		</p>
	<?php endif; ?>
	
	<?php if (isset($comments) && is_array($comments)): ?>
		<a name="comments"></a><h2 class="gray"><?php echo $label['comments'] . ' (' . $comment_count . ')';?></h2>
		<div id="comments">
		<?php foreach ($comments as $value): ?>
			<p>
				<strong>
					<?php echo $label['by'] . ' ' . $value['author'];?>
					<?php echo $label['on'] . ' ' . $value['date'];?>
				</strong><br /><br />
				<?php echo nl2br($value['content']);?>
			</p>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>