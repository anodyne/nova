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
						// reset the add field to have nothing in it
						$('#category-panel-name').val('');
						
						// figure out what we've got in the tags DIV
						var tagsContent = $('#category-panel-content-tags').find('nobr').length;
						
						if (tagsContent == 0)
						{
							$('#category-panel-content-message').fadeOut('normal', function(){
								$('#category-panel-content-tags')
									.html('<nobr><span class="tag" id="' + data + '">' + send.category + '</span></nobr>')
									.append('<input type="hidden" name="categories" value="" />');
							});
						}
						else
						{
							$('#category-panel-content-tags').append('<nobr><span class="tag" id="' + data + '">' + send.category + '</span></nobr>');
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