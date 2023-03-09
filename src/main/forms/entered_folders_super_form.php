<form id="entered-folders-super-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha de ingreso: *</label>

			<input type="date" class="form-control" id="entered-folders-date">	

		</div>

		<div class="col-md-9 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<div id="entered-folders-crime-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="entered-folders-nuc" maxlength="13" onkeypress="validateNumber(event);">			

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">MP Canalizador: *</label>

			<input type="text" class="form-control" id="entered-folders-mp-channeler" maxlength="50">

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<div id="entered-folders-unity-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Carpeta recibida: *</label>

			<select id="entered-folders-recieved-folder" name="tipo" style="height: 40px" class="form-control"  required="true" onchange="hideRejectionReason();">									
				<option value ="1" selected>Si</option>
				<option value ="0">No</option>
			</select>	

		</div>

	</div>

	<div class="form-row" style="display: none;" id="rejection-reason-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Motivo de rechazo: *</label>

			<div id="entered-folders-rejection-reason-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Canalizador: *</label>

			<input type="text" class="form-control" id="entered-folders-channeler" maxlength="50">	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Fiscalía: *</label>

			<select id="entered-folders-fiscalia" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1" selected>Apatzingán</option>
				<option value ="2">La Piedad</option>
				<option value ="3">Lázaro Cárdenas</option>
				<option value ="4">Morelia</option>
				<option value ="5">Uruapan</option>
				<option value ="6">Zamora</option>
				<option value ="7">Zitácuaro</option>
				<option value ="8">Coalcomán</option>
				<option value ="9">Huetamo</option>
				<option value ="10">Jiquilpan</option>
			</select>	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Municipio: *</label>

			<div id="entered-folders-municipality-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Con detenido: *</label>

			<select id="entered-folders-priority" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1">Si</option>
				<option value ="0" selected>No</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Observaciones: *</label>

			<input type="text" class="form-control" id="entered-folders-observations" maxlength="50">

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha carpetas: </label>

			<input type="date" class="form-control" id="entered-folders-folders-date">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Facilitador: </label>

			<div id="entered-folders-facilitator-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Lugar de adscripción: *</label>

			<div id="entered-folders-ascription-place-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Tipo de expediente: *</label>

			<div id="entered-folders-type-file-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-row" id="criminal-cause" style="display: none;">

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Número de causa o cuadernillo: *</label>

			<input type="text" class="form-control" id="entered-folders-cause-number" maxlength="50">

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Nombre del juez: *</label>

			<input type="text" class="form-control" id="entered-folders-judge-name" maxlength="50">

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Región del organo jurisdiccional: *</label>

			<div id="entered-folders-region-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Fecha de emisión: *</label>

			<input type="date" class="form-control" id="entered-folders-emission-date">	

		</div>

		<div class="col-md-2 form-group">

			<label style="font-weight:bold">Judicializada antes del CMASC: *</label>

			<select id="entered-folders-judicialized-before-cmasc" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1" selected>Si</option>
				<option value ="0">No</option>
			</select>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-outline-dark" style="height:38px; width: 100px;"  onclick="resetSection('entered_folders_super')">Nuevo</button>	
		<button type="button" class="btn btn-outline-success" style="height:38px; width: 100px;"  onclick="validateSection('entered_folders_super')">Guardar</button>	
 
	</div>

</form>