<hr>


<table id="tablefleets">
		<tr>
			<td>
				<label>Fleets</label>
			</td>
			<td>
				{{ Form::select('fleets[]', $fleets, '',array('required')) }}
			</td>
				<td>
					<a onClick="addlatar();" class="btn btn-danger btn-order"><i class="icon-plus icon-white"></i></a>
					<a onClick="minlatar();" class="btn btn-danger btn-order"><i class="icon-minus icon-white"></i></a>
				</td>
		</tr>

</table>

<input type="submit" class="btn" value="Create">
