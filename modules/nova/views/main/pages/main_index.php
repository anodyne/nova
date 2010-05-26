<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p>

<?php if (count($news) > 0): ?>
	<br />
	<h2 class="page-subhead"><?php echo ucwords(__('global.sim').' '.__('global.news'));?></h2>
	
	<?php foreach ($news as $n): ?>
		<h4><?php echo html::anchor('main/viewnews/'.$n->id, '&raquo; '.$n->title);?></h4>
		<p class="subtle fontSmall bold">
			<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($n->date);?>
			<?php //echo __('label.by').' '.Utility::print_character_name($n->author_character);?>
			<?php echo __('label.in').' '.$n->category->name;?>
		</p>
		<p><?php echo nl2br($n->content);?></p>
	<?php endforeach;?>
<?php endif;?>