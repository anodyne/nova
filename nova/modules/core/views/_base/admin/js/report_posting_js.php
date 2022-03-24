<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#loader').hide();
		$('#loaded').removeClass('hidden');
		
		$('table.search_users tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search',
			labelText: '',
			inputText: '<?php echo $lang['search_users'];?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		$('table#search_active tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_active',
			labelText: '',
			inputText: '<?php echo $lang['search_active'];?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		$('table#search_npc tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_npc',
			labelText: '',
			inputText: '<?php echo $lang['search_npc'];?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		$('table#search_inactive tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_inactive',
			labelText: '',
			inputText: '<?php echo $lang['search_inactive'];?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
	});
</script>