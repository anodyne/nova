<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	function checkLock() {
		var send = {
			user: "<?php echo $this->session->userdata('userid');?>",
			post: "<?php echo $this->uri->segment(3);?>",
			time: "<?php echo now();?>",
			content: $('#content-textarea').val()
		};
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('ajax/info_check_post_lock');?>",
			data: send,
			success: function(data){
				
				if (data == 0)
					window.location = "<?php echo site_url('write/index');?>";
			}
		});
	}
	
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
		
		$('#content-textarea').elastic();
		
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
				
				$("#all option[value='" + user + "']").prop({ disabled: true });
			}
			
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
			$("#all option[value='" + user + "']").prop({ disabled: false });
			
			return false;
		});
		
		<?php if (isset($replyall)): ?>
			<?php foreach ($replyall as $r): ?>
				$("#all option[value='<?php echo $r;?>']").prop({ disabled: true });
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
		
		<?php if ($this->uri->segment(3)): ?>
			// check the post lock
			setInterval("checkLock()", 10000);
		<?php endif;?>
	});
</script>