<?php
    session_start();
    $dpe_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 5 ? true : false) : false;
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>
<table class="table">
    <thead>
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
<?php
    if($dpe_permissions){
?>
            <th>Observaciones</th>
<?php
    }
    else{
?>
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
<?php
    }
?>
        </tr>
    </thead>
    <tbody>
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
<?php
            if($dpe_permissions){
?>
                <td><?php echo $element['entered_folders_observations']['value']; ?></td>
<?php
            }
            else{
?>
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
    </tbody>
</table>