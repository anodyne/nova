<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style>
.popover .inner { width: 550px !important; }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('[rel=popover]').popover({
			animate: false,
			offset: 5,
			placement: 'right',
			html: true
		});
		
		$('#loading').hide();
		$('#loaded').removeClass('hidden');
	});
</script>