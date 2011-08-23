<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('.do-install').live('click', function(){
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = { genre: $(this).attr('myGenre') };
			
			$.ajax({
				beforeSend: function(){
					// hide the install button
					$th.addClass('hidden');
					
					// show the loader
					$th.next('span').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/installajax/install_genre');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$th.next('span').addClass('hidden');
					
					if (data.code == 1)
					{
						// update which image is shown
						$row.children('td:eq(2)').children('.not-installed').addClass('hidden');
						$row.children('td:eq(2)').children('.installed').removeClass('hidden');
						
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
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = { genre: $(this).attr('myGenre') };
			
			$.ajax({
				beforeSend: function(){
					// hide the uninstall button
					$th.addClass('hidden');
					
					// show the loader
					$row.children('td:eq(3)').children('.loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('setup/installajax/uninstall_genre');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$row.children('td:eq(3)').children('.loading').addClass('hidden');
					
					if (data.code == 1)
					{
						// update the text
						$row.children('td:eq(2)').children('.installed').addClass('hidden');
						$row.children('td:eq(2)').children('.not-installed').removeClass('hidden');
						
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