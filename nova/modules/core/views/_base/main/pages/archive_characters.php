<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($data)): ?>
	<p class="bold fontMedium"><?php echo anchor('archive/index', LARROW .' Back to Archive Index');?></p>
	
	<p>
		<?php echo anchor('archive/characters/active', 'Active Characters');?>
		&middot;
		<?php echo anchor('archive/characters/inactive', 'Inactive Characters');?>
		&middot;
		<?php echo anchor('archive/characters/npc', 'Non-Playing Characters');?>
	</p>
	
	<br /><hr /><br />
	
	<table class="table100">
		<tbody>
		<?php foreach ($data as $key => $value): ?>
			<tr>
				<td colspan="3" class="fontLarge bold"><?php echo $value['dept']?></td>
			</tr>
			<?php foreach ($value['positions'] as $p): ?>
				<?php if (isset($p['characters'])): ?>
					<tr>
						<td width="15"></td>
						<td class="fontMedium align_top"><?php echo $p['position'];?></td>
						<td>
							<?php foreach ($p['characters'] as $c): ?>
								<?php echo $c['name'];?><br />
							<?php endforeach;?>
						</td>
					</tr>
				<?php endif;?>
			<?php endforeach;?>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>