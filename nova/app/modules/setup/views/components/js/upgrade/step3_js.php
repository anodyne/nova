<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#start').live('click', function(){
			var send;
			
			// user defaults
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/upgradeajax/upgrade_user_defaults');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(0) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(0) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(0) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(0) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(0) td:eq(0) .errors').removeClass('hidden');
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(0) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(0) td:eq(0) .errors').removeClass('hidden');
					}
				}
			});
			
			// new post author structure
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/upgradeajax/upgrade_author_structure');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(1) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(1) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(1) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(1) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(1) td:eq(0) .errors').removeClass('hidden');
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(1) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(1) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(1) td:eq(0) .errors').removeClass('hidden');
					}
				}
			});
			
			// sys admins
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/upgradeajax/upgrade_sysadmin');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(2) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(2) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(2) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(2) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(2) td:eq(0) .errors').removeClass('hidden');
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(2) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(2) td:eq(0) .errors').removeClass('hidden');
					}
				}
			});
			
			// schema reorg
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/upgradeajax/upgrade_reorg_schema');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(3) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(3) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(3) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(3) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(3) td:eq(0) .errors').removeClass('hidden');
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(3) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(3) td:eq(0) .errors').removeClass('hidden');
					}
				}
			});
			
			// cache site content
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/upgradeajax/upgrade_cache_content');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(4) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(4) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(4) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(4) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(4) td:eq(0) .errors').removeClass('hidden');
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(4) td:eq(0) .errors .errors-content').html(data.message);
						$('table tbody tr:eq(4) td:eq(0) .errors').removeClass('hidden');
					}
				}
			});
			
			$('#start').ajaxStop(function(){
				$(this).attr('id', 'next').html('Next Step');
 			});
			
			return false;
		});
	});
</script>