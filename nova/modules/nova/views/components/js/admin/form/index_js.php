<script type="text/javascript">
	$(document).ready(function(){

		$(".edit-form").click(function(){
			var key = $(this).data('key');

			$('<div/>').dialog2({
				title: "<?php echo ucwords(__('short.edit', array('thing' => __('form'))));?>",
				content: "<?php echo Uri::create('ajax/update/form');?>/" + key
			});

			return false;
		});
	});
</script>