<script type="text/javascript">
	$(document).ready(function(){
		$('#submitDelete').click(function(){
			return confirm('<?php echo lang('confirm_delete_personallog');?>');
		});
		
		$('#submitPost').click(function(){
			return confirm('<?php echo lang('confirm_post_personallog');?>');
		});
	});
</script>