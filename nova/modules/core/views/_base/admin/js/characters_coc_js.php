<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

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

		$(document).on('click', '#update', function(){
			var parent = $(this).parent().parent().attr('class');
			var list = $('#list').sortable('serialize');
			var data = list + '&' + $.param({'nova_csrf_token': $('input[name=nova_csrf_token]').val()});
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#update').prop({ disabled: true });
				},
				type: "POST",
				url: "<?php echo site_url('ajax/save_coc');?>",
				data: data,
				success: function(data){
					$('.flash_message').remove();
					$('.' + parent).prepend(data);
				},
				complete: function(){
					$('#loading').hide();
					$('#update').prop({ disabled: false });
				}
			});
			
			return false;
		});
		
		$(document).on('click', '.remove', function(){
			var parent = $(this).parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_coc');?>",
				data: { coc: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('.flash_message').remove();
					$('.' + parent).prepend(data);
					
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
		
		$(document).on('click', '#add', function(){
			var parent = $(this).parent().parent().attr('class');
			var id = $('#crew option:selected').val();
			var user = $('#crew option:selected').html();
			
			if (id > 0)
			{
				$.ajax({
					beforeSend: function(){
						$('#loading').show();
						$('#add').prop({ disabled: true });
					},
					type: "POST",
					url: "<?php echo site_url('ajax/add_coc_entry');?>",
					data: { user: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
					success: function(data){
						var content = '<li class="ui-state-default" id="coc_' + id;
						content += '"><div class="float_right"><a href="#" class="remove image" name="remove" id="' + id + '">x</a></div>' + user + '</li>';
						
						$('.flash_message').remove();
						$('.' + parent).prepend(data);
						$(content).hide().appendTo('#list').fadeIn('slow');
						$('.submit-div').fadeIn('slow');
					},
					complete: function(){
						$('#coc_' + id).fadeIn('slow', function(){
							$('#loading').hide();
							$('#add').prop({ disabled: false });
						});
					}
				});
				
				$('#list').sortable('refresh');
			}
			
			return false;
		});
	});
</script>