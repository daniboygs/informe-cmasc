<form id="folders-to-validation-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="folders-to-validation-date">	

		</div>

		<div class="col-md-9 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="folders-to-validation-crime" maxlength="50">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="folders-to-validation-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Monto: *</label>

			<input type="number" class="form-control" id="agreement-amount" min="0">	

		</div>

		<div class="col-md-7 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<input type="text" class="form-control" id="folders-to-validation-unity" maxlength="50">

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('folders_to_validation')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('folders_to_validation')">Guardar</button>	
 
	</div>

</form>