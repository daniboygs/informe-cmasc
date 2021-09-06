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

    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="tableToExcel()">Descargar EXCEL</button>

</div>

<br>

<table class="data-table table table-striped">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha Inicio</th>
        <th>Fecha Ingreso</th>
        <th>Número de oficio</th>
        <th>MP Canalizador</th>
        <th>Motivo de rechazo</th>
<?php
        if($dpe_permissions){
?>
            <th>Observaciones</th>
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
    </tr>
<?php
    if($data != 'null'){

        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr id="rejected-folders-row<?php echo 'folio-'.$element['entered_folders_id']['value']; ?>">
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['entered_folders_nuc']['value']; ?></td>
        <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
        <td><?php echo $element['entered_folders_date']['value']; ?></td>
        <td class="bold-text">
            <input class="input-custom-cell" type="text" id="<?php echo 'folio-'.$element['entered_folders_id']['value']; ?>" name="name" required minlength="4" maxlength="10" size="10" value="<?php echo $element['rejected_folders_folio']['value']; ?>" onchange="onchangeRejectedFolderRow(<?php echo $element['entered_folders_id']['value']; ?>)">
        </td>
        <td><?php echo $element['entered_folders_mp_channeler']['value']; ?></td>
        <td class="align-left"><?php echo $element['entered_folders_rejection_reason']['value'].'.'; ?></td>
<?php
        if($dpe_permissions){
?>
            <td><?php echo $element['entered_folders_observations']['value']; ?></td>
<?php
        }
?>   
        
<?php
        if($crud_permissions){
?>
            <td><button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Editar" onclick="edithRejectedFolder(<?php echo $element['entered_folders_id']['value']; ?>)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        
<?php
            if($element['rejected_folders_folio']['value'] != null){
?>
                <button class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Generar PDF" onclick="createPDF(<?php echo $element['entered_folders_id']['value']; ?>)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></td>
<?php
            }
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
