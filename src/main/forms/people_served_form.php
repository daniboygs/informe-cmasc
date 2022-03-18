<form id="people-served-form" action="#">	

	<div class="form-row">

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="people-served-date">	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="people-served-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Delito: *</label>
			
			<div id="people-served-crime-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<hr>

	<h3>Personas atendidas</h3>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Sexo: *</label>
			
			<select id="people-served-gener" name="tipo" style="height: 40px" class="form-control"  required="true">
				<option value="" selected>Selecciona sexo</option>							
				<option value="Masculino">Masculino</option>
				<option value="Femenino">Femenino</option>
			</select>	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Edad: *</label>

			<input type="number" class="form-control" id="people-served-age" min="0">

		</div>
		
		<div class="col-md-1 form-group">

			<label style="font-weight:bold; width: 100%; color: white;">+</label>

			<button type="button" class="btn btn-outline-primary" style="height:38px;"  onclick="addServedPeopleBySection('people_served')"> + </button>	
			
		</div>

	</div>

	<div id="people-served-table-count"><h3></h3></div>
	

	<div id="people-served-table-section"></div>

	<hr>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-outline-dark" style="height:38px; width: 100px;"  onclick="resetSection('people_served')">Nuevo</button>	
		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;"  onclick="validateSection('people_served')">Guardar</button>	
 
	</div>

</form>