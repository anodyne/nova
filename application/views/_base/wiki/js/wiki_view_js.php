<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var page = $(this).attr('myPage');
			var draft = $(this).attr('myDraft');
			var location = '<?php echo site_url('ajax/revert_wiki_page');?>/' + page + '/' + draft;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		/*$("a[rel*=facebox]").click(function() {
			var num = $(this).attr('myID');
			
			$.facebox(function() {
				$.get('<?php echo site_url();?>/ajax/add_comment_news/'+ num, function(data) {
					$.facebox(data);
				});
			});
			return false;
		});*/
	});
</script>