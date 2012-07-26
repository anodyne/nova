<script type="text/javascript">
	$(document).ready(function(){
		$('[rel*=ignoreVersion]').click(function(){
			var version = $(this).data('version');
			
			$.ajax({
				type: "POST",
				url: "<?php echo Uri::create('setup/ajax/ignore_version');?>",
				data: { version: version },
				success: function(data){
					location.reload(true);
				}
			});
			
			return false;
		});
	});

	$('#next').on('click', function(){

		// hide the controls
		$('.lower').slideUp();

		// show the loading graphic
		$('.#loaded').fadeOut('fast', function(){
			$('#loading').fadeIn();
		});
	});
</script>