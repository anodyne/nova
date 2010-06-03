<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p><br />

<div id="nova-panel">
	<div class="nova-panel-nav">
		<div class="nova-panel-nav-links">
			<ul>
				<li><a href="#"><span>Sim News</span></a></li>
				<li><a href="#"><span>Mission Info</span></a></li>
				<li><a href="#"><span>Recent Activity</span></a></li>
			</ul>
		</div>
		<h1 class="page-subhead">Sim News</h1>
	</div>
	<div class="nova-panel-content">
		<div class="nova-panel-content-news">
			<?php if (count($news) > 0): ?>
				<?php foreach ($news as $n): ?>
					<h4><?php echo html::anchor('main/viewnews/'.$n->id, '&raquo; '.$n->title);?></h4>
					<p class="subtle fontSmall bold">
						<?php echo ucfirst(__('action.posted')).' '.Utility::print_date($n->date);?>
						<?php echo $n->author_character->print_name();?>
						<?php echo __('label.in').' '.$n->category->name;?>
					</p>
					<p><?php echo nl2br($n->content);?></p>
				<?php endforeach;?>
			<?php endif;?>
		</div>
	</div>
</div>