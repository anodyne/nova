<?php

$missions = Jelly::query('mission')
	->where('status', '=', 'current')
	->select();

if (count($missions) > 0):
	foreach ($missions as $m):
	
?>

		<h4><?php echo html::anchor('sim/mission/'.$m->id, $m->title);?></h4>
		
		<?php if (!empty($m->group->name)): ?>
			<p class="subtle fontSmall bold">
				<?php echo ucfirst(__('label.in')).' '.$m->group->name;?>
			</p>
		<?php endif;?>
		
		<p><?php echo nl2br($m->desc);?></p>
		
<?php

	endforeach;	
endif;

?>