<?php $string = random_string('alnum', 8);?>

<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_wiki_page');?>/' + id + '/<?php echo $string;?>';
			if (action == 'cleanup')
				var location = '<?php echo site_url('ajax/wiki_draft_cleanup');?>/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('table.pages_search tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_pages',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("global_wiki") ." ". lang("labels_pages"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
	});
</script>