<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>
<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table class="data-table table table-striped">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha</th>
        <th>Delito</th>
        <th>Motivo de canalización</th>
        <th>Unidad</th>
        <th>Facilitador</th>
        <th>Fiscalía</th>
        <th>Acción</th>
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['folders_to_investigation_nuc']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_date']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_crime']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_channeling_reason']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_unity']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_user']['value']; ?></td>
        <td><?php echo $element['fiscalia']['value']; ?></td>
        <td><button class="btn btn-outline-danger" onclick="deleteRecord('folders_to_investigation', <?php echo $element['folders_to_investigation_id']['value']; ?>)">Eliminar</button></td>
    </tr>
<?php
            $i++;
        }
    }
    else{
?> 
    <tr>
        <td colspan="12" style="text-align: center; padding: 7px;">
            No hay registros
        </td>
    </tr>
<?php

    }
?>
</table>
