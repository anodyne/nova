<script type="text/javascript">
	$(document).ready(function(){
		$('.search-item').live('click', function(){
			$(this).toggleClass('search-item-cancel');
			return false;
		});
		
		$('.search-field-options').live('click', function(){
			$('.search-field-options-list').toggleClass('hidden');
			return false;
		});
		
		$('.opt-list-item').live('click', function(){
			var clicked = $(this).attr('myItem');
			
			// reset the class for the options icon
			$('.search-field').find('span.search-field-options').attr('class', 'search-field-options options-' + clicked);
			
			// hide everything
			$('.search-container').children().addClass('hidden');
			
			// show what needs to be shown
			$('.search-container .' + clicked).removeClass('hidden');
			
			// hide the list
			$('.search-field-options-list').addClass('hidden');
			
			return false;
		});
	});
</script>