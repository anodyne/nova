<br>
<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn tooltip-top" title="<?php echo lang('all forms', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4).'/0');?>" class="btn tooltip-top" title="<?php echo lang('action.add tab', 1);?>"><i class="icon-plus icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit sections', 1);?>"><?php echo $images['sections'];?></a>
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit fields', 1);?>"><?php echo $images['fields'];?></a>
	</div>
</div>
<br>

<?php if ($tabs !== false): ?>
	<table width="100%" class="table-striped sort-tab">
		<tbody class="sort-body">
		<?php foreach ($tabs as $t): ?>
			<tr id="tab_<?php echo $t->id;?>">
				<td class="span9">
					<p>
						<strong><?php echo $t->name;?></strong>
						<?php if ($t->status === Status::INACTIVE): ?>
							<span class="muted">(<?php echo lang('inactive', 1);?>)</span>
						<?php endif;?>
					</p>
				</td>
				<td class="span2">
					<div class="btn-group">
						<a href="<?php echo Uri::create('admin/form/tabs/'.$t->form_key.'/'.$t->id);?>" class="btn btn-mini btn-icon tooltip-top" title="<?php echo lang('action.edit', 1).' '.$t->name;?>"><i class="icon-pencil icon-50"></i></a>
						<?php if (Sentry::user()->has_access('form.delete')): ?>
							<a href="<?php echo Uri::create('admin/form/tabs/'.$t->form_key);?>" class="btn btn-mini btn-icon tooltip-top tab-action" title="<?php echo lang('action.delete', 1).' '.$t->name;?>" data-action="delete" data-id="<?php echo $t->id;?>"><i class="icon-remove icon-50"></i></a>
						<?php endif;?>
					</div>
				</td>
				<td class="span1 reorder"></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|form tabs]]', 1);?></p>
<?php endif;?>