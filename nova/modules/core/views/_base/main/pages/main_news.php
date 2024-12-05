<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($news)): ?>
	<div id="news">
		<?php if (isset($categories)): ?>
			<span class="fontSmall pill-container">
				<a href="<?php echo site_url('main/news/all');?>" class="all pill" myTitle="<?php echo $header;?>"><?php echo $label['all_news'];?></a>

				<?php foreach ($categories as $cat): ?>
					&middot; <a href="<?php echo site_url('main/news/'.$cat['id']);?>" class="show pill" myID="<?php echo $cat['id'];?>" myTitle="<?php echo $header .' '. NDASH .' '. $cat['name'];?>"><?php echo $cat['name'];?></a>
				<?php endforeach; ?>
			</span>
		<?php endif; ?>

		<?php foreach ($news as $value): ?>
			<div class="news <?php echo $value['cat_id'];?>">
				<br />
				<?php echo text_output(anchor('main/viewnews/'. $value['id'], $value['title']), 'h3');?>
				<?php echo text_output(word_limiter($value['content'], 50));?>

				<p class="fontSmall gray">
					<strong><?php echo $label['author'] .'</strong> '. $value['author'];?><br />
					<strong><?php echo $label['posted_on'] .'</strong> '. $value['date'];?><br />
					<strong><?php echo $label['category'] .'</strong> '. $value['category'];?>

					<?php if ($value['comment_count'] > 0): ?>
						<br /><em><?php echo $value['comment_count'] .' '. $label['comments'];?></em>
					<?php endif; ?>
				</p>
			</div>
		<?php endforeach; ?>

		<?php echo $pagination;?>
	</div>
<?php else: ?>
	<?php echo text_output($label['nonews'], 'h3', 'orange');?>

	<?php if (Auth::is_logged_in()): ?>
		<?php echo text_output($label['createnews'], 'p', 'bold gray');?>
	<?php endif;?>
<?php endif;?>