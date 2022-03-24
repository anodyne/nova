<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* strip out the comma from the string */
$manifest_default_values = str_replace(',', '', $manifest_defaults);

if (isset($display))
{
	if ($display == "crew")
	{
		$manifest_default_values = "$('.open').hide();";
		$manifest_default_values.= "$('.npc').hide();";
	}
	if ($display == "npcs")
	{
		$manifest_default_values = "$('.active').hide();";
		$manifest_default_values.= "$('.npc').show();";
	}
	if ($display == "past")
	{
		$manifest_default_values = "$('.active').hide();";
		$manifest_default_values.= "$('.inactive').show();";
	}
	if ($display == "open")
	{
		$manifest_default_values = "$('.active').hide();";
		$manifest_default_values.= "$('.open').show();";
	}
}

?><script type="text/javascript">
	$(document).ready(function() {
		<?php echo $manifest_default_values; ?>
		
		$('#all').click(function() {
			$('.inactive').hide();
			$('.open').hide();
			$('#top-open').hide();
			
			$('.active').show();
			$('.npc').show();
			return false;
		});
		
		$('#active').click(function() {
			$('.inactive').hide();
			$('.npc').hide();
			$('.open').hide();
			$('#top-open').hide();
			
			$('.active').show();
			return false;
		});
		
		$('#npc').click(function() {
			$('.inactive').hide();
			$('.active').hide();
			$('.open').hide();
			$('#top-open').hide();
			
			$('.npc').show();
			return false;
		});
		
		$('#inactive').click(function() {
			$('.active').hide();
			$('.npc').hide();
			$('.open').hide();
			$('#top-open').hide();
			
			$('.inactive').show();
			return false;
		});
		
		$('#open').click(function() {
			$('.active').hide();
			$('.npc').hide();
			$('.inactive').hide();
			
			$('.open').show();
			$('#top-open').show();
			return false;
		});
		
		$('#toggle_open').click(function() {
			$('.open').toggle();
			return false;
		});
		
		$('#toggle_npc').click(function() {
			$('.npc').toggle();
			return false;
		});
		
		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5,
			placement: 'right'
		});
		
		$('#loader').hide();
		$('#manifest').removeClass('hidden');
	});
</script>