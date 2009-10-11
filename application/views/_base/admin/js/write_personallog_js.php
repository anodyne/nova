<script type="text/javascript">
	$(document).ready(function(){
		$('button[value="Delete"]').click(function(){
			window.confirm('<?php echo $this->lang->line('confirm_delete_personallog');?>');
		});
		
		$('button[value="Post"]').click(function(){
			window.confirm('<?php echo $this->lang->line('confirm_post_personallog');?>');
		});
	});
</script>