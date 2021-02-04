<form id="processing-folders-form" action="#">	

	<div class="form-row">

		<!--<div class="col-md-12 form-group">

			<label style="font-weight:bold">Facilitador: *</label>

			<input type="text" class="form-control" id="processing-folders-facilitator" maxlength="50">	

		</div>-->

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de inicio: *</label>

			<input type="date" class="form-control" id="processing-folders-initial-date">	

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Fecha de fin: *</label>

			<input type="date" class="form-control" id="processing-folders-finish-date">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Carpetas de investigación: *</label>

			<input type="number" class="form-control" id="processing-folders-folders" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Atención inmediata: *</label>

			<input type="number" class="form-control" id="processing-folders-inmediate-attention" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">CJIM: *</label>

			<input type="number" class="form-control" id="processing-folders-cjim" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Violencia familiar: *</label>

			<input type="number" class="form-control" id="processing-folders-domestic-violence" min="0">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Delitos cibernéticos: *</label>

			<input type="number" class="form-control" id="processing-folders-cyber-crimes" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Adolecentes: *</label>

			<input type="number" class="form-control" id="processing-folders-teenagers" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Inteligencia patrimonial y financiera: *</label>

			<input type="number" class="form-control" id="processing-folders-swealth-and-finantial-inteligence" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Alto impacto y robo de vehículos: *</label>

			<input type="number" class="form-control" id="processing-folders-high-impact-and-vehicles" min="0">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Derechos humanos y libertad de expresión: *</label>

			<input type="number" class="form-control" id="processing-folders-human-rights" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Fiscalía especializada en combate a la corrupción: *</label>

			<input type="number" class="form-control" id="processing-folders-fight-corruption" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Asuntos especiales: *</label>

			<input type="number" class="form-control" id="processing-folders-special-matters" min="0">	

		</div>

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Asuntos internos: *</label>

			<input type="number" class="form-control" id="processing-folders-internal-affairs" min="0">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-3 form-group">

			<label style="font-weight:bold">Litigación: *</label>

			<input type="number" class="form-control" id="processing-folders-litigation" min="0">	

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('processing_folders')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('processing_folders')">Guardar</button>	
 
	</div>

</form>