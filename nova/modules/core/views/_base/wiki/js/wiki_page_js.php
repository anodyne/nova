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
	});
</script>