<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>users/index</title>
		
		<link rel="stylesheet" href="../nova/app/views/design/style.css">
		
		<script type="text/javascript" src="../nova/modules/assets/js/jquery.js"></script>
		<script type="text/javascript">
			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();
			
			$(document).ready(function(){
				$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
				
				$('[rel=change_user_view]').click(function(){
					var view = $(this).attr('id');
					
					if (view == 'show_all')
					{
						$('#actives').fadeOut('fast', function(){
							$('#all').fadeIn('fast');
						});
					}
					else
					{
						$('#all').fadeOut('fast', function(){
							$('#actives').fadeIn('fast');
						});
					}
					
					return false;
				});
				
				$("#users").keyup(function(){
					delay(function(){
						$.ajax({
							beforeSend: function(){
								$('#no-results').hide();
								$('#results').hide();
								
								$('#results-name').hide();
								$('#results-name ul').empty();
								
								$('#results-email').hide();
								$('#results-email ul').empty();
								
								$('#results-characters').hide();
								$('#results-characters ul').empty();
							},
							url: 'search.php',
							type: 'GET',
							dataType: 'json',
							data: { query: $('#users').val(), type: 'results' },
							success: function(data){
								if ( ! $.isEmptyObject(data))
								{
									if ( ! $.isEmptyObject(data.name))
									{
										$.each(data.name, function(key, value){
											$('#results-name ul').append('<li>' + value.name + '</li>');
										});
										
										$('#results-name').show();
									}
									
									if ( ! $.isEmptyObject(data.email))
									{
										$.each(data.email, function(key, value){
											$('#results-email ul').append('<li>' + value.name + ' (' + value.email + ')' + '</li>');
										});
										
										$('#results-email').show();
									}
									
									if ( ! $.isEmptyObject(data.characters))
									{
										$.each(data.characters, function(key, value){
											$('#results-characters ul').append('<li>' + value.name + ' (' + value.fname + ' ' + value.lname + ')' + '</li>');
										});
										
										$('#results-characters').show();
									}
									
									$('#results').show();
								}
								else
								{
									$('#no-results').show();
								}
							}
						});
					}, 500);
				});
			});
		</script>
	</head>
	<body>
		<section>
			<h1 class="page-head">All Users</h1>
			
			<div id="actives">
				<p><em>Didn't find the user you were looking for? You can <a href="#" rel="change_user_view" id="show_all">find</a> any user in the system instead.</em></p>
				
				<table class="zebra">
					<tbody>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
						<tr>
							<td>First Last</td>
							<td>first.last@example.com</td>
							<td class="align-right"><button class="btn-main">Actions</button></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div id="all" class="hidden">
				<p><em>Done searching? Head <a href="#" rel="change_user_view" id="show_actives">back</a> to the list of active users.</em></p>
				
				<p>Find any user by typing their name, email address or any characters linked to their account.</p>
				
				<p><input type="text" id="users" placeholder="Search for users..."></p>
				
				<div id="results" class="hidden">
					<div id="results-name" class="hidden">
						<h2 class="page-subhead">Names</h2>
						<ul></ul>
					</div>
					
					<div id="results-email" class="hidden">
						<h2 class="page-subhead">Email Addresses</h2>
						<ul></ul>
					</div>
					
					<div id="results-characters" class="hidden">
						<h2 class="page-subhead">Linked Characters</h2>
						<ul></ul>
					</div>
				</div>
				
				<div id="no-results" class="hidden">No results found</div>
			</div>
		</section>
	</body>
</html>