<form id="agreements-form" action="#">	

	<div class="form-row">

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="agreement-date">	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="agreement-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<div id="agreement-crime-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>		

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Cumplimiento: *</label>

			<!--<input type="text" class="form-control" id="agreement-compliance">-->
			
			<select id="agreement-compliance" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="Inmediato" selected>Inmediato</option>
				<option value ="Diferido">Diferido</option>
			</select>	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Total o Parcial: *</label>

			<select id="agreement-total" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1" selected>Total</option>
				<option value ="2">Parcial</option>
			</select>	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Mecanismo: *</label>

			<!--<input type="text" class="form-control" id="agreement-mechanism">-->
			
			<select id="agreement-mechanism" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="Mediación" selected>Mediación</option>
				<option value ="Conciliación">Conciliación</option>
				<option value ="Junta restaurativa">Junta restaurativa</option>
			</select>	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Monto en pesos: *</label>

			<input type="number" class="form-control" id="agreement-amount" min="0">	

		</div>	

	</div>

	<div class="form-row">		

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Monto en especie: *</label>

			<input type="text" class="form-control" id="agreement-amount-in-kind">	

		</div>

	</div>

	<hr>

	<h3>Intervinientes</h3>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Nombre: *</label>

			<input type="text" class="form-control" id="people-served-name" maxlength="75">			

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Apellido Paterno: *</label>

			<input type="text" class="form-control" id="people-served-ap" maxlength="75">			

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Apellido Materno: *</label>

			<input type="text" class="form-control" id="people-served-am" maxlength="75">			

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Sexo: *</label>
			
			<select id="people-served-gener" name="tipo" style="height: 40px" class="form-control"  required="true">
				<option value="" selected>Selecciona sexo</option>							
				<option value="Masculino">Masculino</option>
				<option value="Femenino">Femenino</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Edad: *</label>

			<input type="number" class="form-control" id="people-served-age" min="0" max="200">

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Calidad: *</label>
			
			<select id="people-served-type" name="tipo" style="height: 40px" class="form-control"  required="true">
				<option value="" selected>Selecciona calidad</option>							
				<option value="Solicitante">Solicitante</option>
				<option value="Requerido">Requerido</option>
			</select>	

		</div>
		
		<div class="col-md-1 form-group">

			<label style="font-weight:bold; width: 100%; color: white;">+</label>

			<button type="button" class="btn btn-outline-primary" style="height:38px;"  onclick="addServedPeopleBySection('agreements')"> + </button>	
			
		</div>

	</div>

	<div id="people-served-table-count"><h3></h3></div>


	<div id="people-served-table-section"></div>

	<hr>
	

	<div class="form-buttons">		
		<button type="button" class="btn btn-primary" style="height:38px; float: left;"  onclick="loadSearchForm('agreements')">Busqueda <i class="fa fa-search" aria-hidden="true"></i></button>		
		<button type="button" class="btn btn-outline-dark" style="height:38px; width: 100px;"  onclick="resetSection('agreements')">Nuevo</button>	
		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;"  onclick="validateSection('agreements')">Guardar</button>	
 
	</div>

</form>