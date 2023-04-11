<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#color_scale').change(function() {
			if (this.value === 'custom') {
				$('.custom').show();
			} else {
        $('.custom').hide();
			}
    });
	});
</script>