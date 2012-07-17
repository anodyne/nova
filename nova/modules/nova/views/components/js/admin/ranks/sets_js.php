<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// this fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// makes the rank set list sortable and updates when the sort stops
		$('.sort-ranksets tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				
				$.ajax({
					type: 'POST',
					url: "<?php echo Uri::create('ajax/update/rankset_order');?>",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// what action to take when a rank set action is clicked
		$(document).on('click', '.rankset-action', function(){
			var doaction = $(this).data('action');
			var id = $(this).data('id');

			if (doaction == 'delete')
			{
				$('<div/>').dialog2({
					title: "<?php echo lang('action.delete rank set', 2);?>",
					content: "<?php echo Uri::create('ajax/delete/rankset');?>/" + id
				});
			}

			if (doaction == 'duplicate')
			{
				$('<div/>').dialog2({
					title: "<?php echo lang('action.duplicate rank set', 2);?>",
					content: "<?php echo Uri::create('ajax/add/rankset_duplicate');?>/" + id
				});
			}

			if (doaction == 'update')
			{
				$('<div/>').dialog2({
					title: "<?php echo lang('action.update rank set', 2);?>",
					content: "<?php echo Uri::create('ajax/update/rankset');?>/" + id
				});
			}

			return false;
		});
	});
</script>