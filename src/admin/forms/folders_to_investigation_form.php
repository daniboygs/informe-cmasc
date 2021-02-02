<form id="recieved-folders-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="folders-to-investigation-date">	

		</div>

		<div class="col-md-9 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="folders-to-investigation-crime" maxlength="50">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="folders-to-investigation-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<input type="text" class="form-control" id="folders-to-investigation-unity" maxlength="50">

		</div>

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Motivo de canalización: *</label>

			<input type="text" class="form-control" id="folders-to-investigation-channeling-reason" maxlength="50">

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('folders_to_investigation')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('folders_to_investigation')">Guardar</button>	
 
	</div>

</form>