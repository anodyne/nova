<?php if (isset($error)): ?>
	<p class="error"><?php echo $error;?></p>
<?php endif; ?>

<p>Use this page if you want to change your sim's genre. To do so, you need to change the genre
variable in ./application/config/sol.php from your current selection to your new selection.
Once you've made that change, you can run the change script which will install the new
database tables the new genre will need. Your old genre's database tables will stay intact
in the event you would like to go back to your old genre.</p>

<p>If you want to go back to your old genre, simply change the genre variable back to the genre
that you had previously installed.</p>

<?php echo lang_output('login_proceed');?>

<form method="post" action="<?php echo site_url('install/genre');?>">
	<input type="text" name="email" /><br />
	<input type="password" name="password" /><br /><br />
	
	<input type="submit" name="submit" value="Submit" />
</form>