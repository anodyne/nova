<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
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