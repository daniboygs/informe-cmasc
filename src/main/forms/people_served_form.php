<form id="people-served-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="people-served-date">	

		</div>

		<div class="col-md-9 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="people-served-crime" maxlength="250">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="people-served-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Personas atendidas: *</label>

			<input type="number" class="form-control" id="people-served-number" min="0">	

		</div>

		<div class="col-md-7 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<div id="people-served-unity-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('people_served')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('people_served')">Guardar</button>	
 
	</div>

</form>