<script type="text/javascript">
	$(document).ready(function(){
		$('.category-chooser').click(function(){
			var id = $(this).attr('myid');
			
			if (id == 0)
				$('#news > div').show()
			else
				$('#news > div').show().not('div.' + id).hide();
				
			return false;
		});
	});
</script>