<?php
    session_start();
    
    $crud_permissions = false;

    if(isset($_SESSION['user_data']['type'])){
        if($_SESSION['user_data']['type'] == 1){
            $crud_permissions = true;
        }
    }

    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table class="data-table table table-striped">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha Inicio</th>
        <th>Fecha</th>
        <th>Delito</th>
        <th>Motivo de canalización</th>
        <th>Unidad</th>
        <th>Facilitador</th>
        <th>Fiscalía</th>
<?php
    if($crud_permissions){
?>
        <th>Acción</th>
<?php
    }
?>
    </tr>
<?php
    if($data != 'null'){

        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['folders_to_investigation_nuc']['value']; ?></td>
        <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['folders_to_investigation_crime']['value']['listed_values']; ?></td>
        <td><?php echo $element['folders_to_investigation_channeling_reason']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_unity']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_user']['value']; ?></td>
        <td><?php echo $element['fiscalia']['value']; ?></td>
<?php
        if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('folders_to_investigation', <?php echo $element['folders_to_investigation_id']['value']; ?>)">Eliminar</button></td>
<?php
        }
?>
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
