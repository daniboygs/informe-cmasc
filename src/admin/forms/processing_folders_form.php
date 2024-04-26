<form id="processing-folders-form" action="#">

	<div class="form-row">

		<!--<div class="col-md-12 form-group">

			<label style="font-weight:bold">Facilitador: *</label>

			<input type="text" class="form-control" id="processing-folders-facilitator" maxlength="50">	

		</div>-->

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="search-initial-date">	

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="search-finish-date">	

		</div>

	</div>

	<div class="form-buttons">		

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;" onclick="getRecordsBySection({section: 'processing_folders'})">Buscar</button>

	</div>

</form>