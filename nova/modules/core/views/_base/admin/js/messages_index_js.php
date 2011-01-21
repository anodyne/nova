<script type="text/javascript" src="<?php echo base_url() . MODFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('table.inbox_search tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_inbox',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("labels_inbox"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		$('table.outbox_search tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_outbox',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("actions_sent") ." ". lang("labels_messages"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		/* check all items in the inbox */
		$('#inbox_check_all').click(function(){
			$("div.inbox input[type='checkbox']").attr('checked', $('#inbox_check_all').is(':checked'));
		});
		
		/* check all items in the outbox */
		$('#outbox_check_all').click(function(){
			$("div.outbox input[type='checkbox']").attr('checked', $('#outbox_check_all').is(':checked'));
		});
		
		$('#loading').hide();
		$('#loaded').removeClass('hidden');
	});
</script>