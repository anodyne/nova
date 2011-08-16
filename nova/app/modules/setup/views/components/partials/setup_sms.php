<?php $request = Request::current();?>

<?php if ($request->param('id') == 0): ?>
	<!-- step 3 -->
	<div class="step"></div>
	
	<!-- step 2 -->
	<div class="step"></div>
	
	<!-- step 1 -->
	<div class="step"></div>
<?php endif;?>

<?php if ($request->param('id') == 1): ?>
	<!-- step 3 -->
	<div class="step"></div>
	
	<!-- step 2 -->
	<div class="step step-active"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>

<?php if ($request->param('id') == 2): ?>
	<!-- step 3 -->
	<div class="step step-active"></div>
	
	<!-- step 2 -->
	<div class="step step-complete"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>

<?php if ($request->param('id') == 3): ?>
	<!-- step 3 -->
	<div class="step step-complete"></div>
	
	<!-- step 2 -->
	<div class="step step-complete"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>