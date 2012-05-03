<script type="text/javascript">
	$(document).on('click', '.show-readme', function(e){

		// prevent the default click behavior
		e.preventDefault();

		// get the readme container
		var container = $(this).parent().next().next();

		// figure out if we should be hiding or showing
		if (container.is(':visible'))
			container.addClass('hide');
		else
			container.removeClass('hide');
	});

	$(document).ready(function(){
		
		$(".install").click(function(){
			var location = $(this).data('location');

			$('<div/>').dialog2({
				title: "<?php echo lang('action.install module', 2);?>",
				content: "<?php echo Uri::create('ajax/add/module');?>/" + location
			});

			return false;
		});

		$(".update").click(function(){
			var location = $(this).data('location');

			$('<div/>').dialog2({
				title: "<?php echo lang('action.update module', 2);?>",
				content: "<?php echo Uri::create('ajax/update/module');?>/" + location
			});

			return false;
		});
	});
</script>