<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn tooltip-top" title="<?php echo lang('all forms', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4).'/0');?>" class="btn tooltip-top" title="<?php echo lang('action.add section', 1);?>"><i class="icon-plus icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit tabs', 1);?>"><?php echo $images['tabs'];?></a>
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit fields', 1);?>"><?php echo $images['fields'];?></a>
	</div>
</div>
<br>

<?php if ($tabs !== false): ?>
	<ul class="nav nav-tabs">
	<?php foreach ($tabs as $t): ?>
		<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?><?php if ( (bool) $t->display === false){ echo ' ('.lang('status.inactive', 1).')';}?></a></li>
	<?php endforeach;?>
	</ul>
	
	<div class="tab-content">
	<?php foreach ($tabs as $t): ?>
		<div class="tab-pane" id="<?php echo $t->link_id;?>">
		<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
			<table width="100%" class="table-striped sort-section">
				<tbody class="sort-body">
				<?php foreach ($sections[$t->id] as $s): ?>
					<tr id="section_<?php echo $s->id;?>">
						<td class="span9">
							<p>
								<strong><?php echo $s->name;?></strong>
								<?php if ( (bool) $s->display === false): ?>
									<span class="muted">(<?php echo lang('status.inactive', 1);?>)</span>
								<?php endif;?>
							</p>
						</td>
						<td class="span2">
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key.'/'.$s->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$s->name;?>"><i class="icon-pencil icon-75"></i></a>
								<?php if (Sentry::user()->has_access('form.delete')): ?>
									<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key);?>" class="btn btn-mini tooltip-top section-action" title="<?php echo lang('action.delete', 1).' '.$s->name;?>" data-action="delete" data-id="<?php echo $s->id;?>"><i class="icon-remove icon-75"></i></a>
								<?php endif;?>
							</div>
						</td>
						<td class="span1 reorder"></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="alert"><?php echo lang('[[error.not_found|sections]] for this tab', 1);?></p>
		<?php endif;?>
		</div>
	<?php endforeach;?>
	</div>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<table width="100%" class="table-striped sort-section">
			<tbody class="sort-body">
			<?php foreach ($sections as $s): ?>
				<tr id="section_<?php echo $s->id;?>">
					<td class="span9">
						<p>
							<strong><?php echo $s->name;?></strong>
							<?php if ( (bool) $s->display === false): ?>
								<span class="muted">(<?php echo lang('status.inactive', 1);?>)</span>
							<?php endif;?>
						</p>
					</td>
					<td class="span2">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key.'/'.$s->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$s->name;?>"><i class="icon-pencil icon-75"></i></a>
							<?php if (Sentry::user()->has_access('form.delete')): ?>
								<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key);?>" class="btn btn-mini tooltip-top section-action" title="<?php echo lang('action.delete', 1).' '.$s->name;?>" data-action="delete" data-id="<?php echo $s->id;?>"><i class="icon-remove icon-75"></i></a>
							<?php endif;?>
						</div>
					</td>
					<td class="span1 reorder"></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php else: ?>
		<p class="alert"><?php echo lang('[[error.not_found|form sections]]', 1);?></p>
	<?php endif;?>
<?php endif;?>