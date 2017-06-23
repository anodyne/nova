<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h1 class="page-head">Submit Feedback to Anodyne</h1>

<form>
	<p>
		<input type="radio" name="feedbackType" value="issue"> I think I found an issue with the Nova software
		<input type="radio" name="feedbackType" value="new-feature"> I've got a great idea for a brand new feature in Nova
		<input type="radio" name="feedbackType" value="feature-enhancement"> I've got a really cool idea how to make an existing feature better
	</p>

	<p>
		<kbd>Describe</kbd>
		<textarea name="feedbackContent" rows="10"></textarea>
	</p>
</form>
