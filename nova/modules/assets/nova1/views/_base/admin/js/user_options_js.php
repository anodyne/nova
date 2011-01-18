<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
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