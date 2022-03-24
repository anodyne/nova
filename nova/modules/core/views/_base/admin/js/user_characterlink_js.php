<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#tabs').tabs();
		
		$('table.search_npcs tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("abbr_npcs"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
	});
</script>