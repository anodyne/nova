<script type="text/javascript">
	$(document).ready(function(){
		$('#list').sortable({
			forcePlaceholderSize: true,
			placeholder: 'ui-state-highlight'
		});
		$('#list').disableSelection();
		
		if ($('#list li').length > 0)
		{
			$('.submit-div').show();
		}
		
		$('#update').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var list = $('#list').sortable('serialize');
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#update').attr('disabled', 'disabled');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/save_coc');?>",
				data: list,
				success: function(data){
					$('.flash_message').remove();
					$('.' + parent).prepend(data);
				},
				complete: function(){
					$('#loading').hide();
					$('#update').attr('disabled', '');
				}
			});
			
			return false;
		});
		
		$('.remove').live("click", function(){
			var parent = $(this).parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_coc');?>",
				data: { coc: id },
				success: function(data){
					$('.flash_message').remove();
					$('.' + parent).before(data);
					
					if ($('#list li').length == 1)
					{
						$('.submit-div').fadeOut();
					}
				},
				complete: function(){
					$('#coc_' + id).fadeOut('slow', function(){
						$(this).remove();
					});
				}
			});
			
			return false;
		});
		
		$('#add').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var id = $('#crew option:selected').val();
			var user = $('#crew option:selected').html();
			
			if (id > 0)
			{
				$.ajax({
					beforeSend: function(){
						$('#loading').show();
						$('#add').attr('disabled', 'disabled');
					},
					type: "POST",
					url: "<?php echo site_url('ajax/add_coc_entry');?>",
					data: { user: id },
					success: function(data){
						var content = '<li class="ui-state-default" id="coc_' + id;
						content += '"><div class="float_right"><a href="#" class="remove image" name="remove" id="' + id + '">x</a></div>' + user + '</li>';
						
						$('.flash_message').remove();
						$('.' + parent).before(data);
						$(content).hide().appendTo('#list').fadeIn('slow');
						$('.submit-div').fadeIn('slow');
					},
					complete: function(){
						$('#coc_' + id).fadeIn('slow', function(){
							$('#loading').hide();
							$('#add').attr('disabled', '');
						});
					}
				});
				
				$('#list').sortable('refresh');
			}
			
			return false;
		});
	});
</script>