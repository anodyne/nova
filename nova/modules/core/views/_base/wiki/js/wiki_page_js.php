<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#category-panel-create').click(function(){
			var send = {
				category: $('#category-panel-name').val()
			}
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/wiki_create_category').'/'.$string;?>",
				data: { category: $('#category-panel-name').val(), 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
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
		
		$(document).on('click', '.tag', function(){
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