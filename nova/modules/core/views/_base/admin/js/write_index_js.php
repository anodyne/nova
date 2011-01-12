<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		<?php if ($tab > 0): ?>
			$('#tabs').tabs('select', <?php echo $tab;?>);
		<?php endif; ?>
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
	});
</script>