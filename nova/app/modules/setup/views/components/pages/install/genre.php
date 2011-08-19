<p><?php echo $message;?></p>

<p class="bold"><?php echo Html::anchor('setup/main/index', '&laquo; Back to Setup Center');?></p>

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
				<?php if (Kohana::$config->load('nova.genre') == $key): ?>
					<td class="col-25 fontSmall success bold"><?php echo strtoupper($key);?></td>
				<?php else: ?>
					<td class="col-25 fontSmall subtle"><?php echo strtoupper($key);?></td>
				<?php endif;?>
				<td><strong><?php echo $g['name'];?></strong></td>
				<td class="align-center">
					<strong class="success<?php if ( ! $g['installed']){ echo ' hidden'; }?>">Installed</strong>
					<strong class="error<?php if ($g['installed']){ echo ' hidden'; }?>">Not Installed</strong>
				</td>
				<td class="col-150 align-center">
					<?php if ($key != Kohana::$config->load('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall btn-sec<?php if ( ! $g['installed']){ echo ' hidden'; }?>">Uninstall</button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install btn-sec<?php if ($g['installed']){ echo ' hidden'; }?>">Install</button>
					<span class="loading hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		
		<?php foreach ($additional as $key => $a): ?>
			<tr>
				<?php if (Kohana::$config->load('nova.genre') == $key): ?>
					<td class="col-25 fontSmall success bold"><?php echo strtoupper($key);?></td>
				<?php else: ?>
					<td class="col-25 fontSmall subtle"><?php echo strtoupper($key);?></td>
				<?php endif;?>
				<td class="bold"><?php echo $a['name'];?></td>
				<td class="align-center">
					<strong class="success<?php if ( ! $a['installed']){ echo ' hidden'; }?>">Installed</strong>
					<strong class="error<?php if ($a['installed']){ echo ' hidden'; }?>">Not Installed</strong>
				</td>
				<td class="col-150 align-center">
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