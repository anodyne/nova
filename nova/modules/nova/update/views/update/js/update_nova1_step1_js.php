<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.tipTip.js"></script>

<link rel="stylesheet" href="<?php echo url::base().MODFOLDER;?>/assets/css/jquery.tipTip.css" />

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
		
		var tipOpts = {
			defaultPosition: 'right',
			edgeOffset: 8
		}
		
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(0) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(1) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(1) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(2) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(3) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(4) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(5) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(5) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(6) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(6) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(7) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(7) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(8) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(8) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// spec items and specs form
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(9) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_specs');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(9) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(9) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(9) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(9) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(9) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(9) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// wiki data
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(10) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_wiki');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(10) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(10) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(10) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(10) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(10) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(10) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// applications
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(11) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_applications');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(11) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(11) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(11) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(11) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(11) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(11) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// uploads
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(12) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_uploads');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(12) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(12) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(12) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(12) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(12) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(12) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// docking
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(13) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_docking');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(13) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(13) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(13) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(13) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(13) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(13) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
			}
		});
		
		// settings & messages
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(14) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_settings');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(14) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(14) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(14) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(14) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(14) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(14) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
					$('.tiptip').tipTip(tipOpts);
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