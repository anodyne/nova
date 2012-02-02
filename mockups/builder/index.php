<?php

$page = (isset($_GET['page'])) ? $_GET['page'] : 'default';

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Form Builder</title>
		
		<link rel="stylesheet" href="../assets/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		
		<script type="text/javascript" src="../../nova/modules/assets/js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-transition.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-tab.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-tooltip.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('[rel*="tooltip"]').tooltip();
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="span5">
					<div class="tabbable">
						<ul class="nav tabs">
							<li class="active"><a href="#addField" data-toggle="tab">Add Field</a></li>
							<li><a href="#fieldProperties" data-toggle="tab">Field Properties</a></li>
							<li><a href="#formOptions" data-toggle="tab">Form Options</a></li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane active" id="addField">
								Add field
							</div>
							
							<div class="tab-pane" id="fieldProperties">
								<form>
									<label>Field Label <i rel="tooltip" data-placement="right" title="The field label is the text immediately above the field that tells the user what the field is for" class="icon question-sign"></i></label>
									<input type="text">
									
									<label>Field Type <i rel="tooltip" data-placement="right" title="The field type tells Nova exactly what type of field should be shown on the form" class="icon question-sign"></i></label>
									<select>
										<option>Text field</option>
										<option>Paragraph field</option>
										<option>Dropdown menu</option>
										<option>Radio buttons</option>
									</select>
									
									<div class="row">
										<div class="span3">
											<div class="well">
												<h3>Options</h3>
												
												<label class="inline checkbox">Required <i rel="tooltip" data-placement="right" title="Should this field be required to submit the form?" class="icon question-sign"></i> <input type="checkbox"></label>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="tab-pane" id="formOptions">
								Form options
							</div>
						</div>
					</div>
				</div>
				
				<div class="span7">
					<h1>Form</h1>
				</div>
			</div>
		</div>
	</body>
</html>