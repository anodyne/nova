<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p>

<?php if (count($news) > 0): ?>
	<br />
	<h2 class="page-subhead"><?php echo ucwords(__('global.sim').' '.__('global.news'));?></h2>
	
	<?php foreach ($news as $n): ?>
		<h4><?php echo html::anchor('main/viewnews/'.$n->news_id, '&raquo; '.$n->news_title);?></h4>
		<p class="subtle fontSmall bold">
			<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($n->news_date);?>
			<?php echo __('word.by').' '.Utility::print_character_name($n->news_author_character);?>
			<?php echo __('word.in').' '.$n->newscat_name;?>
		</p>
		<p><?php echo nl2br($n->news_content);?></p>
	<?php endforeach;?>
<?php endif;?>