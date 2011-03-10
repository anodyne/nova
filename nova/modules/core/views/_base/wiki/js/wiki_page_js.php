<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('a[rel=tooltip]').each(function(){
			$(this).qtip({
				content: $(this).attr('tooltip'),
				position: {
					my: 'bottom left',
					at: 'top right'
				},
				style: { 
					classes: 'ui-tooltip-shadow ui-tooltip-dark ui-tooltip-rounded'
				}
			});
		});
		
		$('#category-panel-create').click(function(){
			var send = {
				category: $('#category-panel-name').val()
			}
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/wiki_create_category').'/'.$string;?>",
				data: { category: $('#category-panel-name').val() },
				success: function(data){
					if (data > 0)
					{
						$('#category-panel-name').val('');
						
						if ($('#category-panel-content-tags:empty'))
						{
							$('#category-panel-content-message').fadeOut('normal', function(){
								$('<nobr><span class="tag" id="' + data + '">' + send.category + '</span></nobr>')
									.appendTo('#category-panel-content-tags');
								$('<input type="hidden" name="categories" value="" />').appendTo('#category-panel-content-tags');
							});
						}
						else
						{
							$('<nobr><span class="tag" id="' + data + '">' + send.category + '</span></nobr>')
								.appendTo('#category-panel-content-tags');
						}
					}
				}
			});
			
			return false;
		});
		
		$('.tag').live('click', function(){
			var id = $(this).attr('id');
			var cats = $('[name=categories]').val();
			
			if ($(this).hasClass('tag-active'))
			{
				// make sure we remove the active class
				$(this).removeClass('tag-active');
				
				// we add commas to the start and end of the hidden input to be able to do this
				cats = cats.replace(',' + id + ',', ',');
				
				// update the hidden field
				$('[name=categories]').val(cats);
			}
			else
			{
				// add the active class
				$(this).addClass('tag-active');
				
				// update the hidden field
				$('[name=categories]').val(cats + ',' + id);
			}
			
			return false;
		});
	});
</script>