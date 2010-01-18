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
		
		$('select.skins').each(function(){
			var type = $(this).attr('myType');
			var selected = $('option:selected', this).val();
			var send = { section: type, skin: selected };
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview_image');?>",
				data: send,
				success: function(data){
					$('a.preview-' + type).attr('href', data);
				}
			});
		});
		
		$('a.cb').colorbox({
			transition:	'elastic',
			speed:		400
		});
		
		$('select.skins').change(function(){
			var type = $(this).attr('myType');
			var selected = $('option:selected', this).val();
			var send = { section: type, skin: selected };
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview_image');?>",
				data: send,
				success: function(data){
					$('a.preview-' + type).attr('href', data);
				}
			});
		});
	});
</script>