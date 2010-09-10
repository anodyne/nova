<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.position.min.js"></script>
<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.tooltip.min.js"></script>

<link rel="stylesheet" href="<?php echo url::base().MODFOLDER;?>/assets/css/jquery.ui.tooltip.css" />

<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 50 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
	});
	
	$('#start').live('click', function(){
		var send;
		
		// users
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_users');?>",
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
					$('table tbody tr:eq(0) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(0) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// characters
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_characters');?>",
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
					$('table tbody tr:eq(1) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(1) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(1) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// awards
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_awards');?>",
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
					$('table tbody tr:eq(2) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(2) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// missions
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_missions');?>",
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
					$('table tbody tr:eq(3) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(3) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// posts and post comments
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_posts');?>",
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
					$('table tbody tr:eq(4) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(4) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// logs and log comments
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_logs');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(5) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(5) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(5) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(5) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(5) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(5) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// news, news categories and news comments
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_news');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(6) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(6) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(6) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(6) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(6) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(6) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// private messages
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(7) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_privmsgs');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(7) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(7) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(7) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(7) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(7) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(7) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		// tour items, tour form and decks
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(8) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_tour');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(8) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(8) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(8) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(8) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(8) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(8) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		$('#progress').ajaxStop(function(){
			$("#progress").progressbar({ value: 75 });
			$('#percent').text($('#progress').progressbar('option', 'value') + '%');
			
			// change the button and text
			$('.lower .control button').attr('id', 'next').html('<?php echo __("Next Step");?>');
			$('.lower .control-text').html('<?php echo __("Move on to the final step of the upgrade process.");?>');
		});
		
		return false;
	});
</script>