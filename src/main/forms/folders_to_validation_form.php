<form id="folders-to-validation-form" action="#">	

	<div class="form-row">

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="folders-to-validation-date">	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="folders-to-validation-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<div id="folders-to-validation-crime-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-buttons">		
		<button type="button" class="btn btn-primary" style="height:38px; float: left;"  onclick="loadSearchForm('folders_to_validation')">Busqueda <i class="fa fa-search" aria-hidden="true"></i></button>		
		<button type="button" class="btn btn-outline-dark" style="height:38px; width: 100px;"  onclick="resetSection('folders_to_validation')">Nuevo</button>	
		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;"  onclick="validateSection('folders_to_validation')">Guardar</button>	
 
	</div>

</form>