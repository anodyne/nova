<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// validate certain fields of the join form
		$('#userInfoForm').validate({
			errorElement: 'p',
			errorClass: 'help-block',
			highlight: function(element, errorClass) {
				$(element).closest('.control-group').addClass('error');
			},
			unhighlight: function(element, errorClass) {
				$(element).closest('.control-group').removeClass('error');
			},
			errorPlacement: function(error, element) {
				error.insertAfter(element);
			},
			rules: {
				"basic[confirm_password]": {
					equalTo: $('[name="basic[password]"]')
				}
			}
		});
	});
</script>