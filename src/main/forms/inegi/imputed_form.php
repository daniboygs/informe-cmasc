<form id="inegi-imputed-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Sexo: *</label>

			<select class="form-control" id="inegi-imputed-gener" required="true">									
				<option value ="Masculino" selected>Masculino</option>
				<option value ="Femenino">Femenino</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Edad: *</label>

			<input type="text" class="form-control" id="inegi-imputed-age" maxlength="3" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Escolaridad: *</label>

			<div id="inegi-imputed-scholarship-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

		</div>

	</div>

	

	<div class="form-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Ocupación: *</label>

			<div id="inegi-imputed-ocupation-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Solicitante: *</label>

			<input type="text" class="form-control" id="inegi-imputed-applicant">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Requerido: *</label>

			<select class="form-control" id="inegi-imputed-required" required="true">
				<option value="Solicitante">Solicitante</option>
				<option value="Requerido">Requerido</option>
			</select>		

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Tipo de persona: *</label>

			<select class="form-control" id="inegi-imputed-type" required="true">
				<option value="Física">Física</option>
				<option value="Moral">Moral</option>
			</select>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetInegiSection('imputed')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateInegiSection('imputed')">Guardar</button>	
 
	</div>

</form>