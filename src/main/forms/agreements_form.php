<form id="agreements-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="agreement-date">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<div id="agreement-crime-section">
				<!--<div style="color: #EE6E5A;">Cargando datos... </div>-->

				<select id="agreement-crime" name="tipo" style="height: 40px" class="form-control"  required="true">									
					<option value ="1" selected>Delito 1</option>
					<option value ="2">Delito 2</option>
				</select>
			</div>		

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Intervensión: *</label>

			<input type="number" class="form-control" id="agreement-intervention" min="0">

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="agreement-nuc" maxlength="13">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Cumplimiento: *</label>

			<input type="text" class="form-control" id="agreement-compliance">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Total o Parcial: *</label>

			<select id="agreement-total" name="tipo" style="height: 40px" class="form-control"  required="true">									
				<option value ="1" selected>Total</option>
				<option value ="2">Parcial</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Mecanismo: *</label>

			<input type="text" class="form-control" id="agreement-mechanism">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Monto: *</label>

			<input type="number" class="form-control" id="agreement-amount" min="0">	

		</div>			

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Unidad: *</label>

			<div id="agreement-unity-section">
				<!--<div style="color: #EE6E5A;">Cargando datos... </div>-->

				<select id="agreement-unity" name="tipo" style="height: 40px" class="form-control"  required="true">									
					<option value ="1" selected>Unidad 1</option>
					<option value ="2">Unidad 2</option>
				</select>	

			</div>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('agreements')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('agreements')">Guardar</button>	
 
	</div>

</form>