<table class="table100 zebra">
	<tbody>
	<?php foreach ($fresh->columns as $table => $hash): ?>
		<?php if ($hash != $upgrade->columns[$table]): ?>
			<tr>
				<td><?php echo $table;?></td>
				<td><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></td>
			</tr>
		<?php endif;?>
	<?php endforeach;?>
	</tbody>
</table>