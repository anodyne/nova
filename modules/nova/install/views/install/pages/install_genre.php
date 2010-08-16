<p class="fontMedium"><?php echo $message;?></p>

<p class="fontMedium bold"><?php echo html::anchor('install/index', '&laquo; '.__('Back to Installation Center'));?></p>

<hr />

<?php if (isset($genres)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th colspan="2"><?php echo ucfirst(__('genre'));?></th>
				<th><?php echo ucfirst(__('status'));?></th>
				<th><?php echo ucfirst(__('action'));?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($genres as $key => $g): ?>
			<tr>
				<?php if (Kohana::config('nova.genre') == $key): ?>
					<td class="col-25 fontSmall success bold"><?php echo strtoupper($key);?></td>
				<?php else: ?>
					<td class="col-25 fontSmall subtle"><?php echo strtoupper($key);?></td>
				<?php endif;?>
				<td class="bold"><?php echo $g['name'];?></td>
				<td class="align-center">
					<strong class="success<?php if (!$g['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('installed'));?></strong>
					<strong class="error<?php if ($g['installed']){ echo ' hidden'; }?>"><?php echo ucwords(__('not installed'));?></strong>
				</td>
				<td class="col-150 align-center">
					<?php if ($key != Kohana::config('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall button-small<?php if (!$g['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('uninstall'));?></button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install button-small<?php if ($g['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('install'));?></button>
					<span class="loading hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		
		<?php foreach ($additional as $key => $a): ?>
			<tr>
				<?php if (Kohana::config('nova.genre') == $key): ?>
					<td class="col-25 fontSmall success bold"><?php echo strtoupper($key);?></td>
				<?php else: ?>
					<td class="col-25 fontSmall subtle"><?php echo strtoupper($key);?></td>
				<?php endif;?>
				<td class="bold"><?php echo $a['name'];?></td>
				<td class="align-center">
					<strong class="success<?php if (!$a['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('installed'));?></strong>
					<strong class="error<?php if ($a['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('not installed'));?></strong>
				</td>
				<td class="col-150 align-center">
					<?php if ($key != Kohana::config('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall button-small<?php if (!$a['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('uninstall'));?></button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install button-small<?php if ($a['installed']){ echo ' hidden'; }?>"><?php echo ucfirst(__('install'));?></button>
					<span class="loading hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>