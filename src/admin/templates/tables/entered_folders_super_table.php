<?php
    session_start();
    
    $crud_permissions = false;
    $dpe_permissions = false;

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

<br>

<table class="data-table table table-striped overflow-table">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha Inicio</th>
        <th>Fecha Ingreso</th>
        <th>Delito</th>
        <th>Unidad</th>
        <th>MP Canalizador</th>
        <th>Con detenido</th>
        <th>Carpeta Recibida</th>
        <th>Motivo de rechazo</th>
        <th>Canalizador</th>
        <th>Municipio</th>
        <th>Observaciones</th>
        <th>Fecha Carpetas</th>
        <th>Lugar de adscripción</th>
        <th>Tipo de expediente</th>
        <th>Número de causa o cuadernillo</th>
        <th>Nombre del juez</th>
        <th>Región del organo jurisdiccional</th>
        <th>Fecha de emisión</th>
        <th>Judicializada antes de CMASC</th>
        <th>Facilitador</th>
        <th>Fiscalía</th>
        <!--<th>Fecha Libro</th>-->
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
        <td class="bold-text"><?php echo $element['entered_folders_nuc']['value']; ?></td>
        <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
        <td><?php echo $element['entered_folders_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['entered_folders_crime']['value']['listed_values']; ?></td>
        <td><?php echo $element['entered_folders_unity']['value']; ?></td>
        <td><?php echo $element['entered_folders_mp_channeler']['value']; ?></td>
        <td><?php echo $element['entered_folders_priority']['value']; ?></td>
        <td><?php echo $element['entered_folders_recieved_folder']['value']; ?></td>
        <td><?php echo $element['entered_folders_rejection_reason']['value']; ?></td>
        <td><?php echo $element['entered_folders_channeler']['value']; ?></td>
        <td><?php echo $element['entered_folders_municipality']['value']; ?></td>
        <td><?php echo $element['entered_folders_observations']['value']; ?></td>
        <td><?php echo $element['entered_folders_folders_date']['value']; ?></td>
        <td><?php echo $element['entered_folders_ascription_place']['value']; ?></td>
        <td><?php echo $element['entered_folders_type_file']['value']; ?></td>
        <td><?php echo $element['entered_folders_cause_number']['value']; ?></td>
        <td><?php echo $element['entered_folders_judge_name']['value']; ?></td>
        <td><?php echo $element['entered_folders_region']['value']; ?></td>
        <td><?php echo $element['entered_folders_emission_date']['value']; ?></td>
        <td><?php echo $element['entered_folders_judicialized_before_cmasc']['value']; ?></td>
        <td><?php echo $element['entered_folders_facilitator']['value']; ?></td>
        <td><?php echo $element['entered_folders_fiscalia']['value']; ?></td>
        <td><?php echo $element['fiscalia']['value']; ?></td>

<?php
        if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('entered_folders', <?php echo $element['entered_folders_id']['value']; ?>)">Eliminar</button></td>
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
