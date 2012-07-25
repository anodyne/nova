<script type="text/javascript">
	$(document).ready(function(){

		// set up the fancy choose box
		$('.chzn').chosen();

		<?php if ($type == 'dept'): ?>

			// show the department field
			$('#deptRule').show();
		<?php endif;?>
	});

	$('#ruleType').on('change', function(){

		// get what's selected
		var selected = $('#ruleType option:selected').val();

		if (selected == 'dept')
		{
			// show the div
			$('#deptRule').show();
		}
		else
		{
			// reset the field
			$('[name="condition"]').val('');

			// hide the div
			$('#deptRule').hide();
		}
	});
</script>