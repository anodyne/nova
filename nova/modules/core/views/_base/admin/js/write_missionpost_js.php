<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<link rel="stylesheet" href="<?php echo base_url().MODFOLDER;?>/assets/js/css/bootstrap.css" />

<script type="text/javascript">
	function checkLock() {
		var send = {
			post: "<?php echo $this->uri->segment(3);?>",
			content: $('#content-textarea').val(),
			'nova_csrf_token': $('input[name=nova_csrf_token]').val()
		}
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('ajax/info_check_post_lock');?>",
			data: send,
			success: function(data){
				$('#readonly').hide();
				$('#editable').show();
				
				if (data == 1 || data == 2)
				{
					window.location = "<?php echo site_url('write/index');?>";
				}
				else if (data == 6)
				{
					$('#editable').hide();
					$('#readonly').show();
				}
					
			}
		});
	}
	
	$(document).ready(function(){
		
		// using the CI user agent library instead of jquery's $.browser since the latter is deprecated
		var browser = "<?php echo $this->agent->browser();?>";
		var version = parseFloat("<?php echo $this->agent->version();?>");
		
		// check to see if we should be using the Chosen plugin
		if (browser == 'Internet Explorer' && version < 8)
			$('#chosen-incompat').show();
		else
			$('.chosen').chosen();
		
		$('#toggle_notes').click(function(){
			$('.notes_content').slideToggle('fast');
			return false;
		});

		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5,
			placement: 'right'
		});
		
		$('#submitDelete').click(function(){
			return confirm('<?php echo lang('confirm_delete_missionpost');?>');
		});
		
		$('#submitPost').click(function(){
			return confirm('<?php echo lang('confirm_post_missionpost');?>');
		});
		
		<?php if ($missionCount == 0 and $authorized): ?>
			$.facebox(function(){
				$.get('<?php echo site_url('ajax/add_mission');?>/<?php echo $string;?>', function(data) {
					$.facebox(data);
				});
			});
			
			$(document).on('click', '#addMission', function(){
				var title = $('#addMissionTitle').val();
				var desc = $('#addMissionDesc').val();
				var option = $('#addMissionOption').val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ajax/add_mission_action');?>",
					data: { title: title, desc: desc, option: option, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() }
				});
			});
		<?php endif;?>
		
		// check the post lock ONLY if we're editing a post
		<?php if ($this->uri->segment(3) and $this->uri->segment(4) != 'view'): ?>
			// run the check as soon as we get here
			checkLock();
			
			// now start the normal timer
			setInterval("checkLock()", 300000);
		<?php endif;?>
		
		<?php if ($this->uri->segment(4) == 'view'): ?>
			$('#editable').hide();
			$('#readonly').show();
		<?php endif;?>

		<?php if ($missionNotesUpdate === true): ?>
			$('.notes_content').show();
		<?php endif;?>
	});
</script>