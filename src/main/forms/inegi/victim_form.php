<form id="inegi-victim-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Sexo: *</label>

			<select class="form-control" id="inegi-victim-gener" required="true">									
				<option value ="Masculino" selected>Masculino</option>
				<option value ="Femenino">Femenino</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Edad: *</label>

			<input type="text" class="form-control" id="inegi-victim-age" maxlength="3" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Escolaridad: *</label>

			<div id="inegi-victim-scholarship-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

			<!--<select class="form-control" id="inegi-victim-scholarship" required="true">									
				
				<option value ="1" selected>Prescolar</option>
				<option value ="2">Primaria</option>
				<option value ="3">Secundaria</option>
				<option value ="4">Preparatoria</option>
				<option value ="5">Carrera técnica o comercial</option>
				<option value ="6">Licenciatura</option>
				<option value ="7">Maestría</option>
				<option value ="8">Doctorado</option>
				<option value ="9">Ninguno</option>
				<option value ="10">No identificado</option>
				
			</select>-->

		</div>

	</div>

	

	<div class="form-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Ocupación: *</label>

			<div id="inegi-victim-ocupation-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

			<!--<select class="form-control" id="inegi-victim-ocupation" required="true">		

				<option value="1">FUNCIONARIOS, DIRECTORES Y JEFES</option>
				<option value="2">PROFESIONISTAS Y TECNICOS</option>
				<option value="3">TRABAJADORES AUXILIARES EN ACTIVIDADES ADMINISTRATIVAS</option>
				<option value="4">COMERCIANTES, EMPLEADOS EN VENTAS Y AGENTES DE VENTAS</option>
				<option value="5">TRABAJADORES EN SERVICIOS PERSONALES Y VIGILANCIA</option>
				<option value="6">TRABAJADORES EN ACTIVIDADES AGRICOLAS, GANADERAS, FORESTALES, CAZA Y PESCA</option>
				<option value="7">TRABAJADORES ARTESANALES</option>
				<option value="8">OPERADORES DE MAQUINARIA INDUSTRIAL, ENSAMBLADORES, CHOFERES Y CONDUCTORES</option>
				<option value="9">TRABAJADORES EN ACTIVIDADES ELEMENTALES Y DE APOYO</option>
				<option value="10">AMA DE CASA</option>
				<option value="11">ESTUDIANTE</option>
				<option value="12">NO EJERCIA NINGUNA OCUPACION</option>
				<option value="13">NO IDENTIFICADO</option>

			</select>-->

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Solicitante: *</label>

			<input type="text" class="form-control" id="inegi-victim-applicant">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Requerido: *</label>

			<input type="text" class="form-control" id="inegi-victim-required" maxlength="25">			

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Tipo de persona: *</label>

			<select class="form-control" id="inegi-victim-type" required="true">

				<option value="Física">Física</option>
				<option value="Moral">Moral</option>


			</select>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetInegiSection('victim')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateInegiSection('victim')">Guardar</button>	
 
	</div>

</form>