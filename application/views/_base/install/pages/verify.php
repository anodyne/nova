<br />
<table class="table75 zebra verify">
	<thead>
		<tr>
			<th><?php echo $label['header_comp'];?></th>
			<th><?php echo $label['header_req'];?></th>
			<th><?php echo $label['header_rec'];?></th>
			<th><?php echo $label['header_actual'];?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $label['php'];?></td>
			<td>4.3.2</td>
			<td>5.0.0</td>
			<td><?php echo phpversion();?></td>
		</tr>
		<tr>
			<td><?php echo $label['db'];?></td>
			<td><?php echo $allowed_db_string;?></td>
			<td>mysql</td>
			<td><?php echo $this->db->platform();?></td>
		</tr>
		<tr>
			<td><?php echo $label['dbver'];?></td>
			<td><?php echo $dbver;?></td>
			<td>5.0</td>
			<td><?php echo $this->db->version();?></td>
		</tr>
		<tr>
			<td><?php echo $label['mem'];?></td>
			<td>8M</td>
			<td>32M+</td>
			<td><?php echo ini_get('memory_limit');?></td>
		</tr>
		<tr>
			<td><?php echo $label['regglobals'];?></td>
			<td>&ndash;</td>
			<td><?php echo $label['off'];?></td>
			<td><?php echo $regglobals;?></td>
		</tr>
	</tbody>
</table>

<br />
<?php echo text_output($content);?>

<p>
	<?php echo anchor('install/index', $label['back'], array('class' => 'fontMedium bold'));?>
	<?php echo $label['step1'];?>
</p>