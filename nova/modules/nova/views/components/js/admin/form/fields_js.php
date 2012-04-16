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

		// makes the field list sortable and updates when the sort stops
		$('.sort-field tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				
				$.ajax({
					type: 'POST',
					url: "<?php echo Uri::create('ajax/update/field_order');?>",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// makes the value list sortable and updates when the sort stops
    	$('.sort-value tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				
				$.ajax({
					type: 'POST',
					url: "<?php echo Uri::create('ajax/update/value_order');?>",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

    	$('.field-action').click(function(){
    		var action = $(this).data('action');
    		var id = $(this).data('id');

    		if (action == 'delete')
    		{
	    		$('<div/>').dialog2({
					title: "<?php echo ucwords(__('short.delete', array('thing' => __('field'))));?>",
					content: "<?php echo Uri::create('ajax/delete/field');?>/" + id
				});
	    	}

    		return false;
    	});

    	// show the first tab
    	$('.nav-tabs a:first').tab('show');
	});
</script>