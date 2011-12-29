<div class="page-header">
	<h1>All Users</h1>
</div>

<div class="row">
	<div class="span12">
		<p><button class="btn primary">Add Character</button></p>
		
		<div id="add-character" class="well hide">
			<div class="pull-right"><a href="#" rel="character" class="add-cancel">Cancel</a></div>
			
			<h2 class="page-subhead">Add Character</h2>
			
			<p>You can add a new character to the system by entering their name, position and rank.</p>
			
			<table>
				<tbody>
					<tr>
						<td><input type="text" name="name" placeholder="Name"></td>
						<td>
							<select>
								<option value="">Select a Position</option>
							</select>
						</td>
						<td>
							<select>
								<option value="">Select a Rank</option>
							</select>
						</td>
						<td><button class="btn primary">Submit</button></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="striped-table" id="characters-active">
			<thead>
				<tr>
					<th class="red">Name</th>
					<th class="red">Position</th>
					<th class="red {sorter: false}"></th>
				</tr>
			</thead>
			<tbody>
				<tr class="height-40">
					<td>
						Alex Diaz<br>
						<span class="fontSmall subtle">Captain</span>
					</td>
					<td>
						Commanding Officer<br>
						<span class="fontSmall subtle">Manifest Name</span>
					</td>
					<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
				</tr>
				<tr class="height-40">
					<td>
						Chalasirta Hy'Qiin<br>
						<span class="fontSmall subtle">Commander</span>
					</td>
					<td>
						Executive Officer<br>
						<span class="fontSmall subtle">Manifest Name</span>
					</td>
					<td class="col-50 align-center"><img src="images/admin/actions.png"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>