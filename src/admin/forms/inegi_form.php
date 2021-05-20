<form id="inegi-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="search-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Mes: *</label>

			<input type="month" class="form-control" id="search-month">	

		</div>

	</div>

	<div class="form-buttons">		

		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;"  onclick="searchSection('inegi')">Buscar</button>

	</div>

</form>