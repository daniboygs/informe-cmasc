<form id="entered-folders-form" action="#">	

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fecha de ingreso: *</label>

			<input type="date" class="form-control" id="entered-folders-date">	

		</div>

		<div class="col-md-9 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="entered-folders-crime" maxlength="250">	

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

			<select id="entered-folders-recieved-folder" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1" selected>Si</option>
				<option value ="0">No</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Canalizador: *</label>

			<input type="text" class="form-control" id="entered-folders-channeler" maxlength="50">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fiscalía: *</label>

			<select id="entered-folders-fiscalia" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="Apatzingán" selected>Apatzingán</option>
				<option value ="La Piedad">La Piedad</option>
				<option value ="Lázaro Cárdenas">Lázaro Cárdenas</option>
				<option value ="Morelia">Morelia</option>
				<option value ="Uruapan">Uruapan</option>
				<option value ="Zamora">Zamora</option>
				<option value ="Zitácuaro">Zitácuaro</option>
				<option value ="Coalcomán">Coalcomán</option>
				<option value ="Huetamo">Huetamo</option>
				<option value ="Jiquilpan">Jiquilpan</option>
			</select>	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Municipio: *</label>

			<div id="entered-folders-municipality-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-12 form-group">

			<label style="font-weight:bold">Observaciones: *</label>

			<input type="text" class="form-control" id="entered-folders-observations" maxlength="50">

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha carpetas: *</label>

			<input type="date" class="form-control" id="entered-folders-folders-date">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Facilitador: *</label>

			<div id="entered-folders-facilitator-section">
				<div style="color: #EE6E5A;">Cargando datos... </div>
			</div>

		</div>

		<!--<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha de libro: *</label>

			<input type="date" class="form-control" id="entered-folders-book-date">	

		</div>-->

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-outline-dark" style="height:38px; width: 100px;"  onclick="resetSection('entered_folders')">Nuevo</button>	
		<button type="button" class="btn btn-outline-primary" style="height:38px; width: 100px;"  onclick="validateSection('entered_folders')">Guardar</button>	
 
	</div>

</form>