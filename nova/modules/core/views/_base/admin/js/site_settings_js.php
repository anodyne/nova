<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	function set_sample_output(value)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('ajax/info_format_date');?>",
			data: { format: value },
			success: function(data){
				$('#format_output').html(data);
			}
		});
	}
	
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		/* validation */
		$('#allowed_chars_playing').blur(function() {
			var num = $(this).val();
			
			if (num < 1)
			{
				alert('<?php echo $this->lang->line('alert_pcs_greater_than_zero');?>');
				$(this).val(1);
				$(this).focus();
			}
		});
		
		$('#sys_email_off').click(function(){
			alert('<?php echo $this->lang->line('alert_sys_email_off');?>');
		});
		
		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5,
			placement: 'right',
			html: true
		});
		
		$('select.skins').each(function(){
			var type = $(this).attr('myType');
			var selected = $('option:selected', this).val();
			var send = { section: type, skin: selected, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview_image');?>",
				data: send,
				success: function(data){
					$('a.preview-' + type).attr('href', data);
				}
			});
		});
		
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'dark_rounded',
			social_tools: '<div class="pp_social"></div>'
		});
		
		$('select.skins').change(function(){
			var type = $(this).attr('myType');
			var selected = $('option:selected', this).val();
			var send = { section: type, skin: selected, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview_image');?>",
				data: send,
				success: function(data){
					$('a.preview-' + type).attr('href', data);
				}
			});
		});
		
		$('#rank').change(function(){
			var location = $('#rank option:selected').val();
			
			$.ajax({
				beforeSend: function(){
					$('#loading_rank').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_rank_preview_img');?>",
				data: { rank: location, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#rank_img').html('');
					$('#rank_img').append(data);
				},
				complete: function(){
					$('#loading_rank').hide();
				}
			});
			
			return false;
		});
		
		$('#formats').change(function(){
			var format = $(this).val();
			$('#date_format').val(format);
			set_sample_output(format);
		});
		
		$('#date_format').change(function(){
			var value = $(this).val();
			set_sample_output(value);
		});
	});
</script>