<script type="text/javascript">
	$(document).on('click', '#deleteRanks', function(){
		
		// get the checked state of the checkbox
		var checked = $('#deleteRanks').is(':checked');

		if (checked)
			$('#changeDD').hide();
		else
			$('#changeDD').show();
	});
</script>
<p><?php echo lang('[[short.delete_confirm|rank group|{{'.$name.'}}]]');?></p>

<form method="post">
	<div class="control-group">
		<label class="checkbox"><input type="checkbox" name="delete_ranks" id="deleteRanks" value="1" checked="checked"> <?php echo lang('action.delete ranks', 1);?></label>
	</div>

	<div class="control-group hide" id="changeDD">
		<?php echo Form::select('new_group', 0, $groups, array('class' => 'span4'));?>
		<p class="help-block"><?php echo lang('[[short.ranks.change_group|rank|ranks]]');?></p>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>