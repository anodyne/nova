<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.textboxlist.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.textboxlist.autocomplete.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/GrowingInput.js';?>"></script>
		
<script type="text/javascript">
	$(document).ready(function(){
		var cat = new TextboxList('#categories', {
			unique: true,
			plugins: {
				autocomplete: {
					onlyFromValues: true,
					minLength: 3
				}
			}
		});
		
		<?php if (isset($populate)): ?>
			<?php foreach ($populate as $p): ?>
				cat.add("<?php echo $p['name'];?>", "<?php echo $p['id'];?>");
			<?php endforeach;?>
		<?php endif;?>
		
		$.ajax({
			url: "<?php echo site_url('ajax/info_show_wiki_categories');?>",
			dataType: 'json',
			success: function(r){
				cat.plugins['autocomplete'].setValues(r);
			}
		});
	});
</script>