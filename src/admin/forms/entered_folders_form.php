<form id="entered-folders-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="search-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="search-initial-date">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="search-finish-date">	

		</div>

	</div>

	<div class="form-buttons">

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;" onclick="downloadExcel()">EXCEL</button>

		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;" onclick="getRecordsBySection({section: 'entered_folders'})">Buscar</button>

		<!--<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;"  onclick="searchSectionByRange('entered_folders')">Buscar</button>-->
	</div>

	<div id="delegated-default-modal-section"></div>

	<!--<div class="form-buttons">		

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;"  onclick="checkNucDates()">Buscar Fechas</button>

	</div>-->

</form>