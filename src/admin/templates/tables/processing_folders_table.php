<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>
<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

<button type="button" class="btn btn-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<table style="background-color: white; width: 100%; display: block; overflow-x: auto; white-space: nowrap;" id="data-section-table">
    <tr>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">#</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha de inicio</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha de fin</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Carpetas investigación</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Atención inmediata</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">CJIM</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Violencia familiar</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Delitos cibernéticos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Adolescentes</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Inteligencia patrimonial</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Alto impacto</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Derechos humanos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Combate corrupción</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Asuntos especiales</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Asuntos internos</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Litigación</th>
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
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['fiscalia']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><button class="btn btn-danger" onclick="deleteRecord('processing_folders', <?php echo $element['processing_folders_id']['value']; ?>)">Eliminar</button></td>
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
