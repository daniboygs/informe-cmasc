<div class="subtitle-label-section">CAPTURA GENERAL</div>

<form id="capture-period-form" action="#">

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="capture-period-initial-date">	

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="capture-period-finish-date">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Captura diaria: *</label>

			<input type="checkbox" id="capture-period-daily" value="second_checkbox" onchange="onChangeDaily()">	

		</div>

	</div>

	<div class="form-buttons">	
		
		<div class="period-label" id="capture-period-label"><div style="color: #EE6E5A;">Cargando datos... </div></div>	

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;" onclick="activatePeriod()">Habilitar</button>

	</div>

</form>

<hr>

<div class="subtitle-label-section">CAPTURA INEGI</div>

<form id="capture-period-form" action="#">

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="capture-inegi-period-initial-date">	

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="capture-inegi-period-finish-date">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Captura diaria: *</label>

			<input type="checkbox" id="capture-inegi-period-daily" value="second_checkbox" onchange="onChangeInegiDaily()">	

		</div>

	</div>

	<div class="form-buttons">

		<div class="period-label" id="capture-inegi-period-label"><div style="color: #EE6E5A;">Cargando datos... </div></div>		

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;" onclick="activateInegiPeriod()">Habilitar</button>

	</div>

</form>