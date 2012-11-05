<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div class="wiki-subnav">
	<div class="subnav-options">
		<a href="#" id="toggle-filters"><?php echo img($images['eye']).' '.$label['show'];?></a>
		
		<div class="subnav-options-list">
			<ul>
				<li><a href="#" rel="toggle" id="show_all"><?php echo $label['show_all'].' '.$label['pages'];?></a></li>
				<li><a href="#" rel="toggle" id="show_std"><?php echo $label['show_std'].' '.$label['pages'];?></a></li>
				<li><a href="#" rel="toggle" id="show_sys"><?php echo $label['system'].' '.$label['pages'];?></a></li>
				<li><a href="#" rel="toggle" id="show_res"><?php echo $label['restrict'].' '.$label['pages'];?></a></li>
			</ul>
		</div>
	</div>
	<div class="subnav-content">
		<ul>
			<li>
				<a href="<?php echo site_url('wiki/page');?>"><?php echo img($images['add']).' '.$label['add'];?></a>
			</li>
			
			<?php if (isset($pages)): ?>
				<li>
					<a href="#" rel="facebox" myAction="cleanup" myID="0"><?php echo img($images['clean']) .' '. $label['clean'];?></a>
				</li>
			<?php endif;?>
		</ul>
	</div>
</div>

<?php if (isset($pages)): ?>
	<br /><div class="search_pages"></div><br />
	
	<div id="search_pages">
		<?php foreach ($pages as $p): ?>
			<div id="page-<?php echo $p['id'];?>" class="<?php echo $p['type'].' '.$p['restrictions'];?>">
				<div class="page-main">
					<div class="page-controls">
						<ul>
							<li class="control-active">
								<a href="#" rel="page-control" myID="<?php echo $p['id'];?>" myAction="info" class="image">
									<?php echo img($images['info']);?>
								</a>
							</li>
							<li>
								<a href="#" rel="page-control" myID="<?php echo $p['id'];?>" myAction="history" class="image">
									<?php echo img($images['history']);?>
								</a>
							</li>
							
							<?php if ($p['type'] == 'standard'): ?>
								<li>
									<a href="#" rel="page-control" myID="<?php echo $p['id'];?>" myAction="access" class="image">
										<?php echo img($images['lock']);?>
									</a>
								</li>
								<li><?php echo anchor('wiki/view/page/'.$p['id'], img($images['view']), array('class' => 'image'));?></li>
								<li>
									<a href="#" rel="facebox" myAction="deletePage" myID="<?php echo $p['id'];?>" class="image">
										<?php echo img($images['delete']);?>
									</a>
								</li>
							<?php endif;?>
							
							<li><?php echo anchor('wiki/page/'.$p['id'], img($images['edit']), array('class' => 'image'));?></li>
						</ul>
					</div>
					<?php if ($p['type'] == 'system'): ?>
						<span class="label-system" rel="popover" data-original-title="<?php echo $label['system_label_help_title'];?>" data-content="<?php echo $label['system_label_help'];?>"><?php echo $label['system'];?></span>
					<?php endif;?>
					<?php if ($p['restrictions'] !== FALSE): ?>
						<span class="label-restrict" rel="popover" data-original-title="<?php echo $label['restrict_label_help_title'];?>" data-content="<?php echo $label['restrict_label_help'];?>"><?php echo $label['restrict'];?></span>
					<?php endif;?>
					<strong class="fontMedium"><?php echo $p['title'];?></strong>
				</div>
				<div class="page-supplemental alt fontSmall">
					<div class="page-info">
						<?php echo $label['created'];?>
						<?php if ($p['type'] == 'system'): ?>
							<?php echo $label['system'];?>
						<?php else: ?>
							<?php echo $p['created'].' '.$label['on'].' '.$p['created_date'];?>
						<?php endif;?>
						
						<?php if ($p['updated'] !== FALSE): ?>
							<br />
							<?php echo $label['updated'].' '.$p['updated'].' '.$label['on'].' '.$p['updated_date'];?>
						<?php endif;?>
					</div>
					<div class="page-history hidden">
						<div class="loading"></div>
						<div class="loaded hidden"><?php echo img($images['loading']);?></div>
					</div>
					<div class="page-restrictions hidden">
						<div class="loading"></div>
						<div class="loaded hidden"><?php echo img($images['loading']);?></div>
					</div>
				</div><br/>
			</div>
		<?php endforeach;?>
	</div>
	<?php echo form_open().form_close();?>
<?php else: ?>
	<?php echo text_output($label['nopages'], 'h3', 'orange');?>
<?php endif;?>