<form id="agreements-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="agreements-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>
		
	</div>

	<div class="form-buttons">		

		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="searchSection('agreements')">Buscar</button>
	
	</div>

</form>