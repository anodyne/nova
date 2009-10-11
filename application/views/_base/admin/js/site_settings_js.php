<script type="text/javascript">
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
		
		$('a[rel=tooltip]').each(function(){
			$(this).qtip({
				content: $(this).attr('tooltip'),
				position: {
					corner: {
						target: 'topRight',
						tooltip: 'bottomLeft'
					}
				},
				style: { 
					border: {
						width: 1,
						radius: 4,
					},
					name: 'dark',
					fontSize: '90%'
				}
			});
		});
	});
</script>