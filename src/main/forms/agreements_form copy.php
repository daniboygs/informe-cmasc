<form id="imputed-senap-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">País de residencia: *</label>

			<div id="imputed-country-residence-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Entidad federativa: *</label>

			<div id="imputed-entity-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Municipio: *</label>

			<div id="imputed-municipality-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>		

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Localidad: *</label>

			<div id="imputed-location-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Tipo de asentamiento: *</label>

			<div id="imputed-settlement-types-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Colonia/Asentamiento: *</label>

			<!--<input type="text" class="form-control" id="imputed-suburb" maxlength="100">-->	

			<div id="imputed-suburb-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Tipo de vialidad: *</label>

			<div id="imputed-road-types-select-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Calle/Vialidad: *</label>

			<input type="text" class="form-control" id="imputed-street" maxlength="100">	

		</div>			

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Numero exterior: *</label>

			<input type="text" class="form-control" id="imputed-number" maxlength="10" onkeypress="validateNumber(event);">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Numero interior: </label>

			<input type="text" class="form-control" id="imputed-internal-number" maxlength="5" onkeypress="validateNumber(event);">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Codigo postal: *</label>

			<input type="text" class="form-control" id="imputed-postal-code" maxlength="10" onkeypress="validateNumber(event);">		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Latitud: *</label>

			<input type="text" class="form-control" id="imputed-latitude" maxlength="13" onkeypress="validateNumber(event);">		

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Longitud: *</label>

			<input type="text" class="form-control" id="imputed-longitude" maxlength="13" onkeypress="validateNumber(event);">		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Telefono: *</label>

			<input type="text" class="form-control" id="imputed-phone-number" maxlength="15" onkeypress="validateNumber(event);">		

		</div>

	</div>


	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="limpiaimputado(), resetSelectedImputed()">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateImputedSection('address')">Guardar</button>	

	</div>

</form>