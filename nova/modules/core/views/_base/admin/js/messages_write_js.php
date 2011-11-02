<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function() {
		
		// using the CI user agent library instead of jquery's $.browser since the latter is deprecated
		var browser = "<?php echo $this->agent->browser();?>";
		var version = parseFloat("<?php echo $this->agent->version();?>");
		
		// check to see if we should be using the Chosen plugin
		if (browser == 'Internet Explorer' && version < 8)
			$('#chosen-incompat').show();
		else
			$('.chosen').chosen();
	});
</script>