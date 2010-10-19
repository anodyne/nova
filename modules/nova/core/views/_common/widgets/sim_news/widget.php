<?php

$news = Jelly::query('news')
	->where('status', '=', 'activated')
	->order_by('date', 'desc')
	->limit(5);
	
( ! Auth::is_logged_in()) ? $news->where('private', '=', 'n') : FALSE;

$news = $news->select();

if (count($news) > 0):
	foreach ($news as $n):
	
?>

		<h4><?php echo html::anchor('main/viewnews/'.$n->id, $n->title);?></h4>
		<span class="subtle fontSmall">
			<strong><?php echo ucfirst(__("author"));?>:</strong> <?php echo $n->author_character->print_name();?><br />
			<strong><?php echo ucfirst(__("category"));?>:</strong> <?php echo $n->category->name;?><br />
			<?php echo Date::mdate($n->date);?>
		</span>
		<p><?php echo Text::limit_words($n->content, 50, '...');?></p>
		
<?php

	endforeach;
else:
	echo '<h3 class="warning">'.__("error.not_found", array(':item' => __("news items"))).'</h3>';
endif;

?>