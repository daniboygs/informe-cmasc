<form id="inegi-masc-form" action="#">	

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Mecanismo: *</label>

			<select class="form-control" id="inegi-masc-mechanism" required="true">									
				<option value ="Mediación" selected>Mediación</option>
				<option value ="Conciliación">Conciliación</option>
				<option value ="Junta restaurativa">Junta restaurativa</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Resultado: *</label>

			<select class="form-control" id="inegi-masc-result" required="true">									
				<option value ="Acuerdo" selected>Acuerdo</option>
				<option value ="No acuerdo">No acuerdo</option>
			</select>	

		</div>

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Cumplimiento: *</label>
			
			<select id="inegi-masc-compliance" class="form-control"  required="true">									
				<option value ="Inmediato" selected>Inmediato</option>
				<option value ="Diferido">Diferido</option>
			</select>	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 form-group">

			<label style="font-weight:bold">Total o Parcial: *</label>

			<select id="inegi-masc-total" class="form-control"  required="true">									
				<option value ="1" selected>Total</option>
				<option value ="2">Parcial</option>
			</select>	

		</div>

		<div class="col-md-8 form-group">

			<label style="font-weight:bold">Tipo de reparación de los solucionados: *</label>

			<select class="form-control" id="inegi-masc-repair" required="true">		
				<option value="1">Reconocimiento de responsabilidad y disculpa a la víctima u ofendido</option>
				<option value="2">Compromiso de no repetición de la conducta</option>
				<option value="3">Programas/Tratamientos</option>
				<option value="4">Restitución economica o en especie a la víctima u ofendido</option>
			</select>

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Tipo de conclusión: *</label>

			<select class="form-control" id="inegi-masc-type" required="true">

				<option value="1">Por voluntad de alguno de los intervinientes</option>
				<option value="2">Por inasistencia injustificada</option>
				<option value="3">No se arribo un resultado que solucione la controversia</option>
				<option value="4">Comportamiento irrespetuoso, agressivo o dilatorio</option>
				<option value="5">Desistimiento de los servicios de J.A o M.A</option>
				<option value="6">Otro</option>
				<option value="7">Acuerdo reparatorio</option>


			</select>

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Monto recuperado: *</label>

			<input type="text" class="form-control" id="inegi-masc-recovered-amount">	

		</div>

	</div>

	<div class="form-row">

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Monto inmueble: *</label>

			<input type="text" class="form-control" id="inegi-masc-amount-property">	

		</div>

		<div class="col-md-6 form-group">

			<label style="font-weight:bold">Turnado a: *</label>

			<select class="form-control" id="inegi-masc-turned-to" required="true">

				<option value="1">PValidación / Abstención de investigación</option>
				<option value="2">Validación / Archivo temporal / Seguimiento de acuerdos</option>
				<option value="3">Carpetas de investigación</option>


			</select>

		</div>

	</div>

	<div class="form-buttons">		
				
		<button type="button" class="btn btn-dark" style="height:38px; width: 100px;"  onclick="resetInegiSection('masc')">Nuevo</button>	
		<button type="button" class="btn btn-success" style="height:38px; width: 100px;"  onclick="validateInegiSection('masc')">Guardar</button>	
 
	</div>

</form>