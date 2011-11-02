<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . MODFOLDER;?>/assets/js/css/uniform.default.css" />

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER;?>/assets/js/jquery.uniform.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("input:file").uniform();
	});
</script>