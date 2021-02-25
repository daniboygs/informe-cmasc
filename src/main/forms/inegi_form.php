<div>

	<div class="inegi-sidenav" id="inegi-sidenav" style="width: 15%; float: left;">

		<div class="element active" id="principal-side-div" onclick="changeInegiPanel('general')">
			Datos generales
		</div>
		<div class="element" id="general-side-div" onclick="changeInegiPanel('victim')">
			Víctima
		</div>
		<div class="element" id="address-side-div" onclick="changeInegiPanel('imputed')">
			Imputado
		</div>
		<div class="element" id="conditions-side-div" onclick="changeInegiPanel('crimes')">
			Caracteristicas de los delitos
		</div>
		<div class="element" id="legal-support-side-div" onclick="changeInegiPanel('masc')">
			MASC
		</div>

	</div>

	<form id="inegi-form" action="#">	

		<div class="form-row">

			<div class="col-md-4 form-group">

				<label style="font-weight:bold">Unidad: *</label>

				<input type="text" class="form-control" id="agreement-unity">	

			</div>

		</div>

		<div class="form-buttons">		
					
			<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('agreements')">Nuevo</button>	
			<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('agreements')">Guardar</button>	
	
		</div>

	</form>

</div>