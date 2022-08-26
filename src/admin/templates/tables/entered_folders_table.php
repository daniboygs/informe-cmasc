<?php
    session_start();
    
    $crud_permissions = false;
    $dpe_permissions = false;

    if(isset($_SESSION['user_data']['type'])){
        if($_SESSION['user_data']['type'] == 1){
            $crud_permissions = true;
        }
        if($_SESSION['user_data']['type'] == 5){
            $dpe_permissions = true;
        }
    }

    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		

    <!--<button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>-->

    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="downloadExcelSection('entered_folders')">Descargar EXCEL</button>

</div>

<br>

<table class="data-table table table-striped overflow-table">
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
            <th>Facilitador</th>
            <th>Fiscalía</th>
<?php
        }
?>
        
        
        <!--<th>Fecha Libro</th>-->
<?php
    if($crud_permissions){
?>
        <th>Acción</th>
<?php
    }
?>
</thead>
    </tr>
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
            <td><?php echo $element['entered_folders_facilitator']['value']; ?></td>
            <td><?php echo $element['entered_folders_fiscalia']['value']; ?></td>
<?php
        }
?>   
        
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

        ?>
        </tbody>
        <?php
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
