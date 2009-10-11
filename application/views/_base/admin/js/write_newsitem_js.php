<script type="text/javascript">
	$(document).ready(function(){
		$('button[value="Delete"]').click(function(){
			window.confirm('<?php echo $this->lang->line('confirm_delete_newsitem');?>');
		});
		
		$('button[value="Post"]').click(function(){
			window.confirm('<?php echo $this->lang->line('confirm_post_newsitem');?>');
		});
	});
</script>