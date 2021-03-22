<form id="inegi-crime-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Calificación: *</label>

			<select class="form-control" id="inegi-crime-rate" required="true">									
				<option value ="Ideal" selected>Ideal</option>
				<option value ="Real">Real</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Concurso: *</label>

			<select class="form-control" id="inegi-crime-contest" required="true">									
				<option value ="Grave" selected>Grave</option>
				<option value ="No grave">No grave</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Forma de acción: *</label>

			<select class="form-control" id="inegi-crime-action" required="true">									
				<option value ="Instantaneo" selected>Instantaneo</option>
				<option value ="Permanente">Permanente</option>
				<option value ="Continuado">Continuado</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Comsión: *</label>

			<select class="form-control" id="inegi-crime-commission" required="true">									
				<option value ="Doloso" selected>Doloso</option>
				<option value ="Culposo">Culposo</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Violencia: *</label>

			<select class="form-control" id="inegi-crime-violence" required="true">									
				<option value ="Violento" selected>Violento</option>
				<option value ="No violento">No violento</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Modalidad: *</label>

			<div id="inegi-crime-modality-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

			<!--<select class="form-control" id="inegi-crime-modality" required="true">									
				<option value ="Simple" selected>Simple</option>
				<option value ="Atenuado">Atenuado</option>
				<option value ="Agravado">Agravado</option>
				<option value ="Calificado">Calificado</option>
				<option value ="Agravado/Calificado">Agravado/Calificado</option>
			</select>	-->

		</div>


	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Instrumento: *</label>

			<div id="inegi-crime-instrument-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

			<!--<select class="form-control" id="inegi-crime-weapon" required="true">	
				<option value="Con arma blanca">Con arma blanca</option>
				<option value="Con alguna parte del cuerpo">Con alguna parte del cuerpo</option>
				<option value="Con algún vehículo">Con algún vehículo</option>
				<option value="Con algún medio electronico o informático">Con algún medio electronico o informático</option>
				<option value="Con otro instrumento">Con otro instrumento</option>
			</select>-->

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">¿El delito es atendido en el esquema de justicia alternativa?: *</label>

			<select class="form-control" id="inegi-crime-alternative-justice" required="true">

				<option value="1">Si</option>
				<option value="0">No</option>

			</select>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetInegiCapture(null)">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateInegiSection('crime')">Guardar</button>	
 
	</div>

</form>