<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#toggle_notes').click(function(){
			$('.notes_content').slideToggle('fast');
			return false;
		});
		
		$('#submitDelete').click(function(){
			return confirm('<?php echo lang('confirm_delete_missionpost');?>');
		});
		
		$('#submitPost').click(function(){
			return confirm('<?php echo lang('confirm_post_missionpost');?>');
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
		
		<?php if (isset($replyall)): ?>
			<?php foreach ($replyall as $r): ?>
				$("#all option[value='<?php echo $r;?>']").attr('disabled', 'yes');
			<?php endforeach; ?>
		<?php endif; ?>
		
		<?php if ($missionCount == 0 && $authorized === TRUE): ?>
			$.facebox(function(){
				$.get('<?php echo site_url('ajax/add_mission');?>/<?php echo $string;?>', function(data) {
					$.facebox(data);
				});
			});
			
			$('#addMission').live('click', function(){
				var title = $('#addMissionTitle').val();
				var desc = $('#addMissionDesc').val();
				var option = $('#addMissionOption').val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ajax/add_mission_action');?>",
					data: { title: title, desc: desc, option: option }
				});
			});
		<?php endif;?>
	});
</script>