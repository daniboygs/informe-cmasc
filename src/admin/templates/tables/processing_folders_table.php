<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table class="data-table table table-striped overflow-table">
    <tr>
        <th>#</th>
        <th>Fecha de inicio</th>
        <th>Fecha de fin</th>
        <th>Carpetas investigación</th>
        <th>Atención inmediata</th>
        <th>CJIM</th>
        <th>Violencia familiar</th>
        <th>Delitos cibernéticos</th>
        <th>Adolescentes</th>
        <th>Inteligencia patrimonial</th>
        <th>Alto impacto</th>
        <th>Derechos humanos</th>
        <th>Combate corrupción</th>
        <th>Asuntos especiales</th>
        <th>Asuntos internos</th>
        <th>Litigación</th>
        <th>Medio Ambiente</th>
        <th>Facilitador</th>
        <th>Fiscalía</th>
        <th>Acción</th>
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['processing_folders_initial_date']['value']; ?></td>
        <td><?php echo $element['processing_folders_finish_date']['value']; ?></td>
        <td><?php echo $element['processing_folders_folders']['value']; ?></td>
        <td><?php echo $element['processing_folders_inmediate_attention']['value']; ?></td>
        <td><?php echo $element['processing_folders_cjim']['value']; ?></td>
        <td><?php echo $element['processing_folders_domestic_violence']['value']; ?></td>
        <td><?php echo $element['processing_folders_cyber_crimes']['value']; ?></td>
        <td><?php echo $element['processing_folders_teenagers']['value']; ?></td>
        <td><?php echo $element['processing_folders_swealth_and_finantial_inteligence']['value']; ?></td>
        <td><?php echo $element['processing_folders_high_impact_and_vehicles']['value']; ?></td>
        <td><?php echo $element['processing_folders_human_rights']['value']; ?></td>
        <td><?php echo $element['processing_folders_fight_corruption']['value']; ?></td>
        <td><?php echo $element['processing_folders_special_matters']['value']; ?></td>
        <td><?php echo $element['processing_folders_internal_affairs']['value']; ?></td>
        <td><?php echo $element['processing_folders_litigation']['value']; ?></td>
        <td><?php echo $element['processing_folders_environment']['value']; ?></td>
        <td><?php echo $element['processing_folders_user']['value']; ?></td>
        <td><?php echo $element['fiscalia']['value']; ?></td>
        <td><button class="btn btn-outline-danger" onclick="deleteRecord('processing_folders', <?php echo $element['processing_folders_id']['value']; ?>)">Eliminar</button></td>
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
