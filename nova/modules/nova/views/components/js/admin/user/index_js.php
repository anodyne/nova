<script type="text/javascript">
	$(document).ready(function(){
		
		$('.chzn').chosen();

		$('.close').click(function(){
			
			var item = $(this).attr('rel');
			$('#add-' + item).fadeOut();
			return false;
		});

		$('[rel=change_user_view]').click(function(){
			var view = $(this).attr('id');
			
			if (view == 'show_all')
			{
				$('#actives').fadeOut('fast', function(){
					$('#all').fadeIn('fast');
				});
			}
			else
			{
				$('#all').fadeOut('fast', function(){
					$('#actives').fadeIn('fast');
				});
			}
			
			return false;
		});

		$("#users").keyup(function(){
			delay(function(){
				$.ajax({
					beforeSend: function(){
						$('#no-results').hide();
						$('#results').hide();
						
						$('#results-name').hide();
						$('#results-name ul').empty();
						
						$('#results-email').hide();
						$('#results-email ul').empty();
						
						$('#results-characters').hide();
						$('#results-characters ul').empty();
						
						$('.search-indicator').show();
					},
					url: 'search.php',
					type: 'GET',
					dataType: 'json',
					data: { query: $('#users').val(), type: 'results' },
					success: function(data){
						$('.search-indicator').hide();
						
						if ( ! $.isEmptyObject(data))
						{
							if ( ! $.isEmptyObject(data.name))
							{
								$.each(data.name, function(key, value){
									$('#results-name ul').append('<li>' + value.name + '</li>');
								});
								
								$('#results-name').show();
							}
							
							if ( ! $.isEmptyObject(data.email))
							{
								$.each(data.email, function(key, value){
									$('#results-email ul').append('<li>' + value.name + ' (' + value.email + ')' + '</li>');
								});
								
								$('#results-email').show();
							}
							
							if ( ! $.isEmptyObject(data.characters))
							{
								$.each(data.characters, function(key, value){
									$('#results-characters ul').append('<li>' + value.name + ' (' + value.fname + ' ' + value.lname + ')' + '</li>');
								});
								
								$('#results-characters').show();
							}
							
							$('#results').show();
						}
						else
						{
							$('#no-results').show();
						}
					}
				});
			}, 500);
		});
	});
</script>