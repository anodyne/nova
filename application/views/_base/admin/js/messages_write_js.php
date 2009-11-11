<script type="text/javascript">
	$(document).ready(function() {
		$('a#add_recipient').click(function() {
			var user = $('#recip').val();
			var hidden = $('#to_hidden').val();
			var name = $("option[value='" + user + "']").html();
			
			if (hidden == 0)
			{
				hidden = '';
			}
			
			/* update the hidden field */
			$('#to_hidden').val(hidden + user + ',');
			
			/* update the list of recipients */
			$('#recipients').append('<span class="' + user + '"><a href="#" id="remove_recipient" class="image" myID="' + user + '" myName="' + name + '"><?php echo $remove;?></a>' + name + '<br /></span>');
			
			/* hide the option so it can't be selected again */
			$("#recip option[value='" + user + "']").attr('disabled', 'yes');
			
			return false;
		});
		
		$('a#remove_recipient').live('click', function(event) {
			var user = $(this).attr('myID');
			var name = $(this).attr('myName');
			var hidden = $('#to_hidden').val();
			var new_hidden = hidden.replace(user, "");
			
			/* update the hidden field */
			$('#to_hidden').val(new_hidden);
			
			/* remove the name from the list */
			$('#recipients span.' + user).remove();
			
			/* show the option again */
			$("#recip option[value='" + user + "']").attr('disabled', '');
			
			return false;
		});
		
		<?php if (isset($replyall)): ?>
			<?php foreach ($replyall as $r): ?>
				/* hide the option so it can't be selected again */
				$("#recip option[value='<?php echo $r;?>']").attr('disabled', 'yes');
			<?php endforeach; ?>
		<?php endif; ?>
	});
</script>