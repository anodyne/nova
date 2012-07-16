<?php include_once NOVAPATH.'nova/views/components/js/core/core_js.php';?>

<script type="text/javascript">
	$(document).ready(function(){
		
		$.lazy({
			src: "<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.dialog2.js",
			name: 'dialog2',
			dependencies: {
				js: [
					'<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.form.js',
					'<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.controls.js'
				]
			},
			cache: true
		});

		$.lazy({
			src: "<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.chosen.min.js",
			name: 'chosen',
			dependencies: {
				css: ['<?php echo Uri::base(false);?>nova/modules/assets/css/jquery.chosen.css']
			},
			cache: true
		});
	});
</script>