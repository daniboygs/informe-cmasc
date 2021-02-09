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

		<button type="button" class="btn btn-success" style="height:38px; width: 100px;" onclick="activatePeriod()">Habilitar</button>

	</div>

</form>