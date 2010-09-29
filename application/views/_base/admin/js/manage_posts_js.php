<?php $string = random_string('alnum', 8);?>

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
				location = '<?php echo site_url('ajax/approve');?>/posts/' + id + '/<?php echo $string;?>';
				
			if (action == 'delete')
				location = '<?php echo site_url('ajax/del_post');?>/' + status + '/' + page + '/' + id + '/<?php echo $string;?>';
			
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
			
			if (user != 0 && $("#all option[value='" + user + "']").is(':disabled') == false)
			{
				if (hidden == 0)
				{
					hidden = '';
				}
				
				$('#authors_hidden').val(hidden + ',' + user + ',');
				
				$('#authors').append('<span class="' + user + '"><a href="#" id="remove_author" class="image" myID="' + user + '" myName="' + name + '"><?php echo $remove;?></a>' + name + '<br /></span>');
				
				$("#all option[value='" + user + "']").attr('disabled', 'yes');
			}
			
			return false;
		});
		
		$('a#remove_author').live('click', function(event) {
			var user = $(this).attr('myID');
			var name = $(this).attr('myName');
			var hidden = $('#authors_hidden').val();
			var new_hidden = hidden.replace(user, "");
			
			$('#authors_hidden').val(new_hidden);
			
			$('#authors span.' + user).remove();
			
			$("#all option[value='" + user + "']").attr('disabled', '');
			
			return false;
		});
	});
</script>