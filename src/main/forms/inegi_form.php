<div id="inegi-form">

	<div>
		<div id="pending-records-label-section">PENDIENTES DE CAPTURA</div>
		<div id="inegi-pending-section"></div>
	</div>
	

	<br>

	

	<div id="inegi-capture-section">
		<div class="inegi-sidenav" id="inegi-sidenav">
			<div><button type="button" class="btn btn-outline-primary" style="height:38px; width: 100%; margin-bottom: 10px;"  onclick="resetInegiCapture(null)">Nuevo Registro</button></div>
			<div class="element active" id="general-side-div" onclick="changeInegiPanel('general')">
				Datos generales
			</div>
			<div class="element" id="victim-side-div" onclick="changeInegiPanel('victim')">
				Víctima
			</div>
			<div class="element" id="imputed-side-div" onclick="changeInegiPanel('imputed')">
				Imputado
			</div>
			<div class="element" id="crime-side-div" onclick="changeInegiPanel('crime')">
				Caracteristicas de los delitos
			</div>
			<div class="element" id="masc-side-div" onclick="changeInegiPanel('masc')">
				Datos generales del acuerdo
			</div>
		</div>

		<div id="inegi-form-section"></div>
	</div>

	<div>
		<div id="inegi-current-record-label-section"></div>
		<div id="inegi-current-record-section"></div>
	</div>

</div>