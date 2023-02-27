<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($label['systeminfo'], 'h2', 'page-subhead');?>
<p>
	<strong><?php echo $label['url'];?></strong> <?php echo base_url();?><br /><br />

	<strong><?php echo $label['version_files'];?></strong> <?php echo $version['files'];?><br />
	<strong><?php echo $label['version_db'];?></strong> <?php echo $version['database'];?><br />
	<strong><?php echo $label['version_ci'];?></strong> <?php echo $version['ci'];?><br />
	<strong><?php echo $label['version_php'];?></strong> <?php echo $version['php'];?>
</p>

<?php echo text_output($label['versions'], 'h2', 'page-subhead');?>
<?php echo text_output($label['versions_redirect']);?>

<?php if (isset($_GET['nova3'])) { ?>
	<?php echo text_output('Nova 3 compatibility report', 'h2', 'page-subhead');?>

	<p>Below is a report of Nova 3's current requirements and how your current server configuration stands against those requirements. If there's something that doesn't pass, <strong>don't panic</strong>. There is plenty of time to correct any issues before Nova 3 is available. This is provided purely for informational purposes.</p>

	<table class="zebra">
		<tbody>
			<?php foreach ($nova3 as $check) { ?>
				<tr>
					<td class="bold"><?php echo $check['label'];?></td>
					<td class="col_30">&nbsp;</td>
					<td class="align_top fontLarge">
						<?php if ($check['result'] === true) { ?>
							<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="green" style="height:1.5rem; width:1.5rem;"><g fill="currentColor"><path d="M20.25 12c0 4.55-3.7 8.25-8.25 8.25 -4.56 0-8.25-3.7-8.25-8.25 0-4.56 3.69-8.25 8.25-8.25 4.55 0 8.25 3.69 8.25 8.25Zm1.5 0c0-5.39-4.37-9.75-9.75-9.75 -5.39 0-9.75 4.36-9.75 9.75 0 5.38 4.36 9.75 9.75 9.75 5.38 0 9.75-4.37 9.75-9.75Z"/><path d="M7.91 12.86l2.16 2.16 .53-.54 .53-.54 -.02-.02 -.54.53 .53.53 4.88-4.89c.29-.3.29-.77 0-1.07 -.3-.3-.77-.3-1.07 0l-4.89 4.88c-.3.29-.3.76 0 1.06l.01.01c.7.7 1.76-.36 1.06-1.07l-2.17-2.17c-.3-.3-.77-.3-1.07 0 -.3.29-.3.76 0 1.06Z"/></g><path fill="none" d="M0 0h24v24H0Z"/></svg>
						<?php } else { ?>
							<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="red" style="height:1.5rem; width:1.5rem;"><path fill="none" d="M0 0h24v24H0Z"/><g fill="currentColor"><path d="M14.29 8.63l-5.66 5.66c-.3.29-.3.76 0 1.06 .29.29.76.29 1.06 0l5.66-5.66c.29-.3.29-.77 0-1.07 -.3-.3-.77-.3-1.07 0Z"/><path d="M15.36 14.29L9.7 8.63c-.3-.3-.77-.3-1.07 0 -.3.29-.3.76 0 1.06l5.66 5.66c.29.29.76.29 1.06 0 .29-.3.29-.77 0-1.07Z"/><path d="M12 20.25c-4.56 0-8.25-3.7-8.25-8.25 0-4.56 3.69-8.25 8.25-8.25 4.55 0 8.25 3.69 8.25 8.25 0 4.55-3.7 8.25-8.25 8.25Zm0 1.5c5.38 0 9.75-4.37 9.75-9.75 0-5.39-4.37-9.75-9.75-9.75 -5.39 0-9.75 4.36-9.75 9.75 0 5.38 4.36 9.75 9.75 9.75Z"/></g></svg>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>