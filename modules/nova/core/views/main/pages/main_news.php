<h1 class="page-head"><?php echo $header;?></h1>

<div id="news">
	<?php if (isset($news)): ?>
		<?php if (isset($categories)): ?>
			<p>
				<strong><?php echo ucfirst(__("categories"));?>:</strong>
				<?php echo html::anchor('#', ucwords(__("all :news", array(':news' => __("news")))), array('myid' => 0, 'class' => 'category-chooser'));?>
				&middot;
				
				<?php foreach ($categories as $c): ?>
					<?php echo html::anchor('#', $c->name, array('myid' => $c->id, 'class' => 'category-chooser'));?>
					<?php if ($lastcategory[$c->id] !== TRUE): ?>
						&middot;
					<?php endif;?>
				<?php endforeach;?>
			</p>
			<hr />
		<?php endif;?>
		
		<?php foreach ($news as $n): ?>
			<div class="<?php echo $n->category->id;?>">
				<h4><?php echo html::anchor('main/viewnews/'.$n->id, $n->title);?></h4>
				<span class="fontSmall subtle">
					<strong><?php echo ucfirst(__("author"));?>:</strong> <?php echo $n->author_character->print_name();?><br />
					<strong><?php echo ucfirst(__("category"));?>:</strong> <?php echo $n->category->name;?><br />
					<?php echo Date::mdate($n->date);?>
				</span>
				<p><?php echo Text::limit_words($n->content, 50, '...');?></p>
				<hr />
			</div>
		<?php endforeach;?>
	<?php else: ?>
		<h3 class="warning"><?php echo __("error.not_found", array(':item' => __("news items")));?></h3>
	<?php endif;?>
</div>