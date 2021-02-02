<form id="agreements-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Fecha: *</label>

			<input type="date" class="form-control" id="agreement-date">	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Delito: *</label>

			<input type="text" class="form-control" id="agreement-crime">			

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Intervensión: *</label>

			<input type="number" class="form-control" id="agreement-intervention" min="0">

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">NUC: *</label>

			<input type="text" class="form-control" id="agreement-nuc" maxlength="13" onkeypress="validateNumber(event);">			

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

			<input type="text" class="form-control" id="agreement-unity">	

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetSection('agreements')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateSection('agreements')">Guardar</button>	
 
	</div>

</form>