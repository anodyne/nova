<h1 class="page-head"><?php echo $header;?></h1>

<div id="tabs">
	<ul>
		<li><a href="#active"><?php echo ucwords(__(":active :users", array(':active' => __('active'), ':users' => __('users'))));?></a></li>
		<li><a href="#inactive"><?php echo ucwords(__(":inactive :users", array(':inactive' => __('inactive'), ':users' => __('users'))));?></a></li>
		<li><a href="#retired"><?php echo ucwords(__(":retired :users", array(':retired' => __('retired'), ':users' => __('users'))));?></a></li>
		<li><a href="#pending"><?php echo ucwords(__(":pending :users", array(':pending' => __('pending'), ':users' => __('users'))));?></a></li>
	</ul>
	
	<div id="active">
		<?php if (isset($users['active'])): ?>
			<?php foreach ($users['active'] as $u): ?>
				<p><?php echo $u->name;?></p>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	
	<div id="inactive">
		<?php if (isset($users['inactive'])): ?>
			<?php foreach ($users['inactive'] as $u): ?>
				<p><?php echo $u->name;?></p>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	
	<div id="retired">
		<?php if (isset($users['retired'])): ?>
			<?php foreach ($users['retired'] as $u): ?>
				<p><?php echo $u->name;?></p>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	
	<div id="pending">
		<?php if (isset($users['pending'])): ?>
			<?php foreach ($users['pending'] as $u): ?>
				<p><?php echo $u->name;?></p>
			<?php endforeach;?>
		<?php endif;?>
	</div>
</div>