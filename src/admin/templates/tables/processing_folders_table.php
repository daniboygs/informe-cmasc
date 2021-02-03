<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>
<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table style="border: solid 1px #ccc; background-color: white; width: 100%; display: block; overflow-x: auto; white-space: nowrap;" id="data-section-table">
    <tr>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">#</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha de Inicio</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha de Fin</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Carpetas Investigacion</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Atencion Inmediata</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">CJIM</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Violencia Familiar</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">DelitosCiberneticos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Adolecentes</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">InteligenciaPatrimonial</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Alto Impacto</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Derechos Humanos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Combate Corrupcion</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Asuntos Especiales</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Asuntos Internos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Litigacion</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Facilitador</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Acción</th>
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $i; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_initial_date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_finish_date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_folders']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_inmediate_attention']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_cjim']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_domestic_violence']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_cyber_crimes']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_teenagers']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_swealth_and_finantial_inteligence']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_high_impact_and_vehicles']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_human_rights']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_fight_corruption']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_special_matters']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_internal_affairs']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_litigation']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['processing_folders_user']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><button class="btn btn-danger" onclick="deleteRecord('processing_folders', <?php echo $element['processing_folders_id']['value']; ?>)">Eliminar</button></td>
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
