<script type="text/javascript">
	$(document).ready(function(){

		$(".edit-form").click(function(){
			var key = $(this).data('key');

			$('<div/>').dialog2({
				title: "<?php echo lang('action.edit form', 2);?>",
				content: "<?php echo Uri::create('ajax/update/form');?>/" + key
			});

			return false;
		});
	});
</script>