<form id="inegi-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="search-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="search-initial-date">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="search-finish-date">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Rubro de busqueda: *</label>

			<select id="inegi-search-op" name="tipo" style="height: 40px" class="form-control"  required="true" onchange="hideRejectionReason();">									
				<option value ="1" selected>Registros capturados</option>
				<option value ="2">Datos generales</option>
				<option value ="3">Datos generales del acuerdo</option>
				<option value ="4">Víctima</option>
				<option value ="5">Imputado</option>
				<option value ="6">Delito</option>
				<option value ="7">Pendientes de captura</option>
			</select>	

		</div>

	</div>

	<div class="form-buttons">
		
		<button type="button" class="btn btn-outline-success" style="height:38px; width: 200px;"  onclick="getRecExcel()">Descargar EXCEL</button>

		<button type="button" class="btn btn-outline-dark" style="height:38px;"  onclick="searchPendngInegi()">Buscar Pendientes de captura</button>

		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 200px;"  onclick="searchSectionByRange('inegi')">Buscar</button>

	</div>

</form>