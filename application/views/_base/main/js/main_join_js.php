<script type="text/javascript">
	$(document).ready(function(){
		$('#position').change(function(){
			var id = $('#position option:selected').val();
			
			$('#loading_update').ajaxStart(function(){
				$(this).show();
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_position_desc');?>",
				data: { position: id },
				success: function(data){
					$('#position_desc').html('');
					$('#position_desc').append(data);
				}
			});
			
			$('#loading_update').ajaxStop(function(){
				$(this).hide();
			});
			
			return false;
		});
	});
</script>