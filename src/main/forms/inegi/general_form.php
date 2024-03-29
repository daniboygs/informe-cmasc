<form id="inegi-general-form" action="#">	

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="inegi-general-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="inegi-general-date">	

		</div>

		<!--<div class="col-md-6 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="inegi-general-crime" maxlength="100">			

		</div>-->

	</div>

	<div class="form-row">

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<div id="inegi-general-unity-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

			<!--<input type="text" class="form-control" id="inegi-general-unity">-->

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Intervinientes: *</label>

			<input type="text" class="form-control" id="inegi-general-attended" maxlength="4" onkeypress="validateNumber(event);">			

		</div>

	</div>

	<div>

		<label style="font-weight:bold">Delitos: </label>

		<div class="" id="inegi-general-crime-section"><div style="color: #EE6E5A;">Cargando datos... </div></div>		

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;"  onclick="validateInegiSection('general')">Guardar</button>	
 
	</div>

</form>