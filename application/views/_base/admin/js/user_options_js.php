<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('#skin_main').change(function(){
			var id = $('#skin_main option:selected').val();
			var section = 'main';
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview');?>",
				data: {
					skin: id,
					section: section
				},
				success: function(data){
					$('#skin_main_preview').html('');
					$('#skin_main_preview').append(data);
				}
			});
			
			return false;
		});
		
		$('#skin_admin').change(function(){
			var id = $('#skin_admin option:selected').val();
			var section = 'admin';
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview');?>",
				data: {
					skin: id,
					section: section
				},
				success: function(data){
					$('#skin_admin_preview').html('');
					$('#skin_admin_preview').append(data);
				}
			});
			
			return false;
		});
		
		$('#skin_wiki').change(function(){
			var id = $('#skin_wiki option:selected').val();
			var section = 'wiki';
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_skin_preview');?>",
				data: {
					skin: id,
					section: section
				},
				success: function(data){
					$('#skin_wiki_preview').html('');
					$('#skin_wiki_preview').append(data);
				}
			});
			
			return false;
		});
	});
</script>