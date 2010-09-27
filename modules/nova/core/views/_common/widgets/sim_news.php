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
		<p class="subtle fontSmall bold">
			<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($n->date);?>
			<?php echo $n->author_character->print_name();?>
			<?php echo __('label.in').' '.$n->category->name;?>
		</p>
		<p><?php echo nl2br($n->content);?></p>
		
<?php

	endforeach;	
endif;

?>