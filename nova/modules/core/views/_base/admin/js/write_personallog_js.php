<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<script type="text/javascript">
	$(document).ready(function(){

		// using the CI user agent library instead of jquery's $.browser since the latter is deprecated
		var browser = "<?php echo $this->agent->browser();?>";
		var version = parseFloat("<?php echo $this->agent->version();?>");

		// check to see if we should be using the Chosen plugin
		if (browser == 'Internet Explorer' && version < 8)
		{
			// don't do anything
		}
		else
		{
			$('.chosen').chosen();
		}

		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5,
			placement: 'right'
		});

		$('#submitDelete').click(function(){
			return confirm('<?php echo lang('confirm_delete_personallog');?>');
		});

		$('#submitPost').click(function(){
			return confirm('<?php echo lang('confirm_post_personallog');?>');
		});

		const textArea = document.getElementById('content-textarea');
		const counter = document.getElementById('counter');

		counter.innerHTML = getWordCount(textArea.value);

		textArea.addEventListener('input', function () {
			let textLn = textArea.value;

			counter.innerHTML = getWordCount(textLn);
		});

		function getWordCount(str) {
			if (str === '') return 0;

			return str.trim().split(/\s+/).length;
		}
	});
</script>