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

			<select class="form-control" id="inegi-imputed-scholarship" required="true">									
				<option value ="Ninguno" selected>Ninguno</option>
				<option value ="Prescolar">Prescolar</option>
				<option value ="Primaria">Primaria</option>
				<option value ="Secundaria">Secundaria</option>
				<option value ="Preparatoria">Preparatoria</option>
				<option value ="Carrera técnica o comercial">Carrera técnica o comercial</option>
				<option value ="Licenciatura">Licenciatura</option>
				<option value ="Maestría">Maestría</option>
				<option value ="Doctorado">Doctorado</option>
				<option value ="No identificado">No identificado</option>
				
			</select>

		</div>

	</div>

	

	<div class="form-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Ocupación: *</label>

			<select class="form-control" id="inegi-imputed-ocupation" required="true">		

				<option value="FUNCIONARIOS, DIRECTORES Y JEFES">FUNCIONARIOS, DIRECTORES Y JEFES</option>
				<option value="PROFESIONISTAS Y TECNICOS">PROFESIONISTAS Y TECNICOS</option>
				<option value="TRABAJADORES AUXILIARES EN ACTIVIDADES ADMINISTRATIVAS">TRABAJADORES AUXILIARES EN ACTIVIDADES ADMINISTRATIVAS</option>
				<option value="COMERCIANTES, EMPLEADOS EN VENTAS Y AGENTES DE VENTAS">COMERCIANTES, EMPLEADOS EN VENTAS Y AGENTES DE VENTAS</option>
				<option value="TRABAJADORES EN SERVICIOS PERSONALES Y VIGILANCIA">TRABAJADORES EN SERVICIOS PERSONALES Y VIGILANCIA</option>
				<option value="TRABAJADORES EN ACTIVIDADES AGRICOLAS, GANADERAS, FORESTALES, CAZA Y PESCA">TRABAJADORES EN ACTIVIDADES AGRICOLAS, GANADERAS, FORESTALES, CAZA Y PESCA</option>
				<option value="TRABAJADORES ARTESANALES">TRABAJADORES ARTESANALES</option>
				<option value="OPERADORES DE MAQUINARIA INDUSTRIAL, ENSAMBLADORES, CHOFERES Y CONDUCTORES">OPERADORES DE MAQUINARIA INDUSTRIAL, ENSAMBLADORES, CHOFERES Y CONDUCTORES</option>
				<option value="TRABAJADORES EN ACTIVIDADES ELEMENTALES Y DE APOYO">TRABAJADORES EN ACTIVIDADES ELEMENTALES Y DE APOYO</option>
				<option value="NO EJERCIA NINGUNA OCUPACION">NO EJERCIA NINGUNA OCUPACION</option>
				<option value="AMA DE CASA">AMA DE CASA</option>
				<option value="ESTUDIANTE">ESTUDIANTE</option>
				<option value="NO IDENTIFICADO">NO IDENTIFICADO</option>

			</select>

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Solicitante: *</label>

			<input type="text" class="form-control" id="inegi-imputed-applicant">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Requerido: *</label>

			<input type="text" class="form-control" id="inegi-imputed-required" maxlength="25">			

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