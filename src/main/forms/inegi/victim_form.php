<form id="inegi-victim-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Sexo: *</label>

			<input type="text" class="form-control" id="inegi-victim-gener">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Edad: *</label>

			<input type="text" class="form-control" id="inegi-victim-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="inegi-victim-crime">			

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<input type="text" class="form-control" id="inegi-victim-unity">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">N° Atendidos en carpeta: *</label>

			<input type="text" class="form-control" id="inegi-victim-attended" maxlength="4" onkeypress="validateNumber(event);">			

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetInegiSection('victim')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateInegiSection('victim')">Guardar</button>	
 
	</div>

</form>