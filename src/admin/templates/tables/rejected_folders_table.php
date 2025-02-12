<?php
    session_start();
    $crud_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 1 ? true : false) : false;
    $dpe_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 5 ? true : false) : false;
    $data = isset( $_POST['data']) ? $_POST['data'] : null;
    $nuc = isset($_POST['nuc']) ? $_POST['nuc'] : null;
    $initial_date = isset($_POST['initial_date']) ? $_POST['initial_date'] : null;
    $finish_date = isset($_POST['finish_date']) ? $_POST['finish_date'] : null;

    $initial_date = $initial_date != null ? str_replace('-', '/', date('d-m-Y', strtotime($initial_date))) : null;
    $finish_date = $finish_date != null ? str_replace('-', '/', date('d-m-Y', strtotime($finish_date))) : null;
    $composite_date = ($initial_date != null && $finish_date != null) 
    ? ($nuc != null ? '('.$initial_date.' - '.$finish_date.' - '.$nuc.')' : '('.$initial_date.' - '.$finish_date.')')
    : ($nuc != null ? '('.$nuc.')' : null);
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		
    <button type="button" class="btn btn-outline-danger" id="rejected_folders_pdf_btn" style="height:38px; width: 10em;"  onclick="rejectedFoldersPDF()">Descargar PDF</button>
    <button type="button" class="btn btn-success" id="rejected_folders_save_btn" style="height:38px; width: 10em; display: none;"  onclick="validateRejectedData()">Guardar</button>
</div>

<div class="table-records-header-text">CARPETAS RECHAZADAS &nbsp<a><?php echo $composite_date ?></a></div>

<div id="rejected_folders_messaje"></div>

<table class="data-table table table-striped overflow-table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha Inicio</th>
            <th>Fecha Ingreso</th>
            <th>Número de oficio</th>
            <th>MP Canalizador</th>
            <th>Motivo de rechazo</th>
            <th>Fiscalía</th>
<?php
    if($dpe_permissions){
?>
            <th>Observaciones</th>
<?php
    }
    if($crud_permissions){
?>
        <th>Acción</th>
<?php
    }
?>
        </tr>
    </thead>
    <tbody>
<?php
    if($data != null){

        $i=1;

        foreach(json_decode($data, true) as $element){
?> 
        <tr id="rejected-folders-row<?php echo '-'.$element['entered_folders_id']['value']; ?>">
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['entered_folders_nuc']['value']; ?></td>
            <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
            <td><?php echo $element['entered_folders_date']['value']; ?></td>
            <td class="bold-text">
                <input class="input-custom-cell" type="text" id="<?php echo 'folio-'.$element['entered_folders_id']['value']; ?>" name="name" required minlength="4" maxlength="20" size="10" value="<?php echo $element['rejected_folders_folio']['value']; ?>" onchange="onchangeRejectedFolderRow(<?php echo $element['entered_folders_id']['value']; ?>)">
            </td>
            <td><?php echo $element['entered_folders_mp_channeler']['value']; ?></td>
            <td class="align-left"><?php echo $element['entered_folders_rejection_reason']['value'].'.'; ?></td>
            <td class="align-left"><?php echo $element['fiscalia']['value']; ?></td>
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
            <!--<td><button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Editar" onclick="edithRejectedFolder(<?php /*echo $element['entered_folders_id']['value'];*/ ?>)"><i class="fa fa-pencil" aria-hidden="true"></i></button>-->
            <td id="<?php echo 'action-btn-'.$element['entered_folders_id']['value']; ?>">
<?php
                if($element['rejected_folders_folio']['value'] != null){
?>
                <button class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Generar PDF" onclick="createPDF(<?php echo $element['entered_folders_id']['value']; ?>)"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
<?php
                }
                else{
?>
                N/A
<?php
                }
?>
            </td>
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