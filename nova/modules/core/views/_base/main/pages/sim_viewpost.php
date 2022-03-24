<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($next) || isset($prev)): ?>
	<div class="float_right">
		<?php if (isset($prev)): ?>
			<?php echo anchor('sim/viewpost/'. $prev, img($images['prev']), array('class' => 'image'));?>
		<?php endif; ?>
		
		<?php if (isset($next)): ?>
			<?php echo anchor('sim/viewpost/'. $next, img($images['next']), array('class' => 'image'));?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php echo text_output($title, 'h1', 'page-head');?>

<?php if ($status != "activated"): ?>
	<p class="bold orange"><?php echo $label['nonactivepost'];?></p>
<?php endif;?>

<p>
	<?php echo link_to_if(in_array(TRUE, $valid), 'manage/posts/edit/'. $post_id, $label['edit'], array('class' => 'edit fontSmall bold'));?>
</p>

<p class="fontSmall bold gray">
	<?php echo $label['posted'];?> <?php echo $date;?>
	<?php echo $label['by'];?> <?php echo $author;?>
	<?php if (isset($update)): ?>
		<br />
		<?php echo $label['edited'] .' '. $label['on'] .' '. $update;?><br />
	<?php endif;?>
</p>

<p class="fontSmall gray">
	<strong><?php echo $label['mission'];?></strong>
	<?php echo anchor('sim/missions/id/'. $mission_id, $mission);?>
	
	<?php if (!empty($location)): ?>
		<br /><strong><?php echo $label['location'] .'</strong> '. $location;?>
	<?php endif; ?>
	
	<?php if (!empty($timeline)): ?>
		<br /><strong><?php echo $label['timeline'] .'</strong> '. $timeline;?>
	<?php endif; ?>
	
	<?php if (!empty($tags)): ?>
		<br /><strong><?php echo $label['tags'] .'</strong> '. $tags;?>
	<?php endif; ?>
</p>

<?php echo text_output($content);?>

<p>&nbsp;</p>

<?php if (isset($next) || isset($prev)): ?>
	<div class="float_right">
		<?php if (isset($prev)): ?>
			<?php echo anchor('sim/viewpost/'. $prev, img($images['prev']), array('class' => 'image'));?>
		<?php endif; ?>
		
		<?php if (isset($next)): ?>
			<?php echo anchor('sim/viewpost/'. $next, img($images['next']), array('class' => 'image'));?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<p><?php echo anchor('feed/posts', img($images['feed']), array('class' => 'image'));?></p>

<?php if (Auth::is_logged_in()): ?>
	<p class="bold">
		<a href="#" id="add_comment" myID="<?php echo $post_id;?>" rel="facebox" class="image">
			<?php echo img($images['comment']) .' '. $label['addcomment'];?>
		</a>
	</p>
<?php endif; ?>

<?php if (isset($comments) and is_array($comments)): ?>
	<a name="comments"></a><h2 class="gray"><?php echo $label['comments'] . ' (' . $comment_count . ')';?></h2>
	<div id="comments">
	<?php foreach ($comments as $value): ?>
		<p>
			<strong>
				<?php echo ucfirst($label['by']) . ' ' . $value['author'];?>
				<?php echo $label['on'] . ' ' . $value['date'];?>
			</strong><br /><br />
			<?php echo nl2br($value['content']);?>
		</p>
	<?php endforeach; ?>
	</div>
<?php endif; ?>