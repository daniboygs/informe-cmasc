<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>
<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table style="background-color: white; width: 100%; overflow-x: auto;" id="data-section-table">
    <tr>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">#</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">NUC</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Delito</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Motivo de canalización</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Unidad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Facilitador</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fiscalía</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Acción</th>
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $i; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_nuc']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_crime']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_channeling_reason']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_unity']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['folders_to_investigation_user']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['fiscalia']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><button class="btn btn-danger" onclick="deleteRecord('folders_to_investigation', <?php echo $element['folders_to_investigation_id']['value']; ?>)">Eliminar</button></td>
    </tr>
<?php
            $i++;
        }
    }
    else{
?> 
    <tr>
        <td colspan="7" style="text-align: center; padding: 7px;">
            No hay registros
        </td>
    </tr>
<?php

    }
?>
</table>
