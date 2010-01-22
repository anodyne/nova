<script type="text/javascript">
	$(document).ready(function(){
		$tabs = $('#tabs').tabs();
		$tabs.tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function(){
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'comment')
			{
				var id = $(this).attr('myID');
				
				location = '<?php echo site_url('ajax/add_comment_wiki');?>/' + id;
			}
			else if (action == 'revert')
			{
				var page = $(this).attr('myPage');
				var draft = $(this).attr('myDraft');
				
				location = '<?php echo site_url('ajax/revert_wiki_page');?>/' + page + '/' + draft;
			}
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>