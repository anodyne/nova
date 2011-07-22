<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.chosen').chosen();
		
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
		
		<?php if ($missionCount == 0 and $authorized): ?>
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