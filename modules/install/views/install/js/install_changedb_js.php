<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('.do-install').live('click', function(){
			var genre = $(this).attr('myGenre');
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = {
				genre: genre
			};
			
			$.ajax({
				beforeSend: function(){
					// hide the install button
					$th.addClass('hidden');
					
					// show the loader
					$th.next('span').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('ajax/install_genre');?>",
				data: send,
				success: function(data){
					// hide the loader
					$th.next('span').addClass('hidden');
					
					if (data == "1")
					{
						// update the text
						$row.children('td:eq(1)').children('strong.error').addClass('hidden');
						$row.children('td:eq(1)').children('strong.success').removeClass('hidden');
						
						// show the uninstall button
						$th.prev('button').removeClass('hidden');
					}
					else
					{
						// show the install button because it's failed
						$th.removeClass('hidden');
					}
				}
			});
			
			return false;
		});
		
		$('.do-uninstall').live('click', function(){
			var genre = $(this).attr('myGenre');
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = {
				genre: genre
			};
			
			$.ajax({
				beforeSend: function(){
					// hide the uninstall button
					$th.addClass('hidden');
					
					// show the loader
					$th.next('span').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('ajax/uninstall_genre');?>",
				data: send,
				success: function(data){
					// hide the loader
					$th.next('span').addClass('hidden');
					
					if (data == "1")
					{
						// update the text
						$row.children('td:eq(1)').children('strong.success').addClass('hidden');
						$row.children('td:eq(1)').children('strong.error').removeClass('hidden');
						
						// show the install button
						$th.next('button').removeClass('hidden');
					}
					else
					{
						// show the uninstall button because it's failed
						$th.removeClass('hidden');
					}
				}
			});
			
			return false;
		});
	});
</script>