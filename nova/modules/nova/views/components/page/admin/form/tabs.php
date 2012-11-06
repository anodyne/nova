<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('all forms', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4).'/0');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.add tab', 1);?>"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit sections', 1);?>"><?php echo $images['sections'];?></a>
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo lang('action.edit fields', 1);?>"><?php echo $images['fields'];?></a>
	</div>
</div>

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
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/form/tabs/'.$t->form_key.'/'.$t->id);?>" class="btn btn-mini tooltip-top" title="<?php echo lang('action.edit', 1).' '.$t->name;?>"><div class="icn icn-50" data-icon="p"></div></a>
						</div>

						<?php if (Sentry::user()->hasAccess('form.delete')): ?>
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/form/tabs/'.$t->form_key);?>" class="btn btn-mini btn-danger tooltip-top tab-action" title="<?php echo lang('action.delete', 1).' '.$t->name;?>" data-action="delete" data-id="<?php echo $t->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
								
							</div>
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