<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var page = $(this).attr('myPage');
			var status = $(this).attr('myStatus');
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'approve')
				location = '<?php echo site_url('ajax/approve');?>/posts/' + id;
				
			if (action == 'delete')
				location = '<?php echo site_url('ajax/del_post');?>/' + status + '/' + page + '/' + id;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('a#add_author').click(function() {
			var user = $('#all').val();
			var hidden = $('#authors_hidden').val();
			var name = $("option[value='" + user + "']").html();
			
			if (hidden == 0)
			{
				hidden = '';
			}
			
			/* update the hidden field */
			$('#authors_hidden').val(hidden + ',' + user + ',');
			
			/* update the list of recipients */
			$('#authors').append('<span class="' + user + '"><a href="#" id="remove_author" class="image" myID="' + user + '" myName="' + name + '"><?php echo $remove;?></a>' + name + '<br /></span>');
			
			/* hide the option so it can't be selected again */
			$("#all option[value='" + user + "']").attr('disabled', 'yes');
			
			return false;
		});
		
		$('a#remove_author').live('click', function(event) {
			var user = $(this).attr('myID');
			var name = $(this).attr('myName');
			var hidden = $('#authors_hidden').val();
			var new_hidden = hidden.replace(user, "");
			
			/* update the hidden field */
			$('#authors_hidden').val(new_hidden);
			
			/* remove the name from the list */
			$('#authors span.' + user).remove();
			
			/* show the option again */
			$("#all option[value='" + user + "']").attr('disabled', '');
			
			return false;
		});
	});
</script>