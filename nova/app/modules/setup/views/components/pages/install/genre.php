<p>From here, you can see the status of genres and either install or uninstall them as needed. The only limitation you have is that you cannot uninstall the current genre. If you want to uninstall the current genre, you'll need to change the genre code in your Nova config file (<code><?php echo APPFOLDER;?>/config/nova.php</code>), save and upload the file, then come back here to uninstall the genre.</p>

<p class="bold"><a href="<?php echo Url::site('setup/main/index');?>">&laquo; Back to Setup Center</a></p>

<hr>

<?php if (isset($genres)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th colspan="2">Genre</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($genres as $key => $g): ?>
			<tr>
				<td class="col-25 fontSmall">
					<?php if (Kohana::$config->load('nova.genre') == $key): ?>
						<span class="success bold">
					<?php else: ?>
						<span class="subtle">
					<?php endif;?>
					
					<?php echo strtoupper($key);?></span>
				</td>
				<td><strong><?php echo $g['name'];?></strong></td>
				<td class="align-center">
					<span class="installed<?php if ( ! $g['installed']){ echo ' hidden'; }?>"><?php echo Html::image($images['installed']['src'], $images['installed']['attr']);?></span>
					<span class="not-installed<?php if ($g['installed']){ echo ' hidden'; }?>"><?php echo Html::image($images['notinstalled']['src'], $images['notinstalled']['attr']);?></span>
				</td>
				<td class="align-center">
					<?php if ($key != Kohana::$config->load('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall btn-sec<?php if ( ! $g['installed']){ echo ' hidden'; }?>">Uninstall</button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install btn-sec<?php if ($g['installed']){ echo ' hidden'; }?>">Install</button>
					<span class="loading hidden"><?php echo Html::image($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		
		<?php foreach ($additional as $key => $a): ?>
			<tr>
				<td class="col-25 fontSmall">
					<?php if (Kohana::$config->load('nova.genre') == $key): ?>
						<span class="success bold">
					<?php else: ?>
						<span class="subtle">
					<?php endif;?>
					
					<?php echo strtoupper($key);?></span>
				</td>
				<td><strong><?php echo $a['name'];?></strong></td>
				<td class="align-center">
					<span class="installed<?php if ( ! $g['installed']){ echo ' hidden'; }?>"><?php echo Html::image($images['installed']['src'], $images['installed']['attr']);?></span>
					<span class="not-installed<?php if ($g['installed']){ echo ' hidden'; }?>"><?php echo Html::image($images['notinstalled']['src'], $images['notinstalled']['attr']);?></span>
				</td>
				<td class="align-center">
					<?php if ($key != Kohana::$config->load('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall btn-sec<?php if ( ! $a['installed']){ echo ' hidden'; }?>">Uninstall</button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install btn-sec<?php if ($a['installed']){ echo ' hidden'; }?>">Install</button>
					<span class="loading hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>