<div class="btn-toolbar">
	<div class="btn-group">
		<a href="#" class="btn tooltip-top" title="<?php echo lang('action.add user', 1);?>"><i class="icon-plus icon-75"></i></a>
		<a href="#" class="btn tooltip-top" title="<?php echo lang('action.add user', 1);?>"><i class="icon-resize-small icon-75"></i></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn tooltip-top" title="<?php echo lang('action.search for user', 1);?>"><i class="icon-search icon-75"></i></a>
	</div>
</div><br>

<div id="add-user" class="hide well well-small">
	<a class="close" href="#">&times;</a>
	
	<h3>Add User</h3>
	
	<p>You can add a new user to the system by entering their name and email address and clicking submit. During creation, a password will be generated for the user and emailed to them along with the rest of their information.</p>

	<?php echo Form::open();?>
		<div class="row">
			<div class="span4">
				<div class="control-group">
					<label class="control-label"><?php echo lang('name', 1);?></label>
					<div class="controls">
						<input type="text" name="name" value="" class="span4">
					</div>
				</div>
			</div>

			<div class="span7">
				<div class="control-group">
					<label class="control-label"><?php echo lang('email_address', 1);?></label>
					<div class="controls">
						<div class="input-append">
							<input type="email" name="email" value="" class="span4"><button type="submit" name="submit" class="btn"><?php echo lang('action.submit', 1);?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php echo Form::hidden('action', 'add');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::close();?>
</div>

<div id="add-character" class="hide well well-small">
	<a class="close" href="#">&times;</a>
	
	<h3>Add Character to User Account</h3>
	
	<p>You can add characters to a user's account by entering the user name or email address and entering the name of the character. During creation, the user will be emailed to notify them of the new character associated with their account.</p>

	<?php echo Form::open();?>
		<div class="control-group">
			<label class="control-label"><?php echo lang('user', 1);?></label>
			<div class="controls">
				<?php echo NovaForm::users('user', array(), array('class' => 'span5 chzn'));?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label"><?php echo lang('character', 1);?></label>
			<div class="controls">
				<?php //echo NovaForm::characters('character', array(), array('class' => 'span5 chzn'));?>
			</div>
		</div>

		<div class="controls">
			<button type="submit" name="submit" class="btn"><?php echo lang('action.submit', 1);?></button>
		</div>

		<?php echo Form::hidden('action', 'link');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::close();?>
</div>

<div id="actives">
	<p><em>Didn't find the user you were looking for? You can <a href="#" rel="change_user_view" id="show_all">find</a> any user in the system instead.</em></p>
	
	<table class="table table-striped" id="users-active">
		<tbody>
		<?php foreach($active as $a): ?>
			<tr>
				<td>
					<span class="lead"><?php echo $a->name;?></span><br>
					<span class="muted"><?php echo $a->email;?></span>
				</td>
				<td class="span2">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/user/edit/'.$a->id);?>" class="btn btn-mini btn-icon tooltip-top" title="<?php echo lang('action.edit user', 1);?>"><i class="icon-pencil icon-50"></i></a>
						</div>

						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/user/edit/'.$a->id);?>" class="btn btn-mini btn-icon btn-danger tooltip-top" title="<?php echo lang('action.delete user', 1);?>"><i class="icon-remove icon-white icon-50"></i></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>

<div id="all" class="hide">
	<p><em>Done searching? Head <a href="#" rel="change_user_view" id="show_actives">back</a> to the list of active users.</em></p>
	
	<p>Find any user by typing their name, email address or any characters linked to their account.</p>
	
	<p>
		<input type="text" id="users" placeholder="Search for users...">
		<span class="search-indicator hidden">&nbsp; <img src="images/admin/loading.gif" alt=""></span>
	</p>
	
	<div id="results" class="hidden">
		<div id="results-name" class="hidden">
			<h2 class="page-subhead">Names</h2>
			<ul></ul>
		</div>
		
		<div id="results-email" class="hidden">
			<h2 class="page-subhead">Email Addresses</h2>
			<ul></ul>
		</div>
		
		<div id="results-characters" class="hidden">
			<h2 class="page-subhead">Linked Characters</h2>
			<ul></ul>
		</div>
	</div>
	
	<div id="no-results" class="hidden">No results found</div>
</div>