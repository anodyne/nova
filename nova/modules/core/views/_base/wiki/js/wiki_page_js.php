<script type="text/javascript" src="<?php echo base_url() . MODFOLDER;?>/assets/js/jquery.qtip.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('a[rel=tooltip]').each(function(){
			$(this).qtip({
				content: $(this).attr('tooltip'),
				position: {
					corner: {
						tooltip: 'bottomLeft',
						target: 'topRight'
					}
				},
				style: { 
					border: {
						width: 1,
						radius: 4,
					},
					name: 'dark',
					fontSize: '90%'
				}
			});
		});
	});
</script>