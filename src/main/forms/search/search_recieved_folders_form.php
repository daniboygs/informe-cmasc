<form id="recieved-folders-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="search-nuc" maxlength="15" onkeypress="validateNumber(event);">			

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
		<button type="button" class="btn btn-primary" style="height:38px; float: left;"  onclick="softLoadForm('recieved_folders')">Capturar <i class="fa fa-pencil" aria-hidden="true"></i></button>		

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;"  onclick="searchSection('recieved_folders')">Buscar</button>
	
	</div>

</form>