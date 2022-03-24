<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		var $tabs = $('#tabs').tabs();
		
		$('#nextTab').click(function(){
			var value = parseInt($tabs.tabs('option', 'selected'));
			var length = $tabs.tabs('length');
			
			value = value + 1;
			length = length - 1;
			
			if (value <= length)
				$tabs.tabs('select', value);
			
			return false;
		});
		
		$('#submitJoin').click(function(){
			return confirm('<?php echo lang('confirm_join');?>');
		});
		
		$('#position').change(function(){
			var id = $('#position option:selected').val();
			
			$('#loading_update').ajaxStart(function(){
				$(this).show();
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_position_desc');?>",
				data: { position: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
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