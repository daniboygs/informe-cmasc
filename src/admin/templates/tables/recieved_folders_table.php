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
    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="formHTMLTableToExcel({section: 'recieved_folders'})">DESCARGAR &nbsp <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
</div>

<div class="table-records-header-text">CARPETAS RECIBIDAS &nbsp<a><?php echo $composite_date ?></a></div>

<table class="data-table table table-striped overflow-table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha Inicio</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Unidad</th>
            <th>Acuerdo</th>
            <th>Fecha Acuerdo</th>
            <th>Fecha Validación</th>
            <th>Fecha Investigación</th>
            <th>Estatus</th>
<?php
    if(!$dpe_permissions){
?>
            <th>Facilitador</th>
<?php
    }
?>
            <th>Fiscalía</th>
<?php
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

            $current_status_style = $element['recieved_folders_status']['value'] == 'Tramite' ? 'background-color: #fff3cd;' : 'background-color: #d4edda;';
?> 
        <tr>
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['recieved_folders_nuc']['value']; ?></td>
            <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
            <td><?php echo $element['recieved_folders_date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['recieved_folders_crime']['value']; ?></td>
            <td><?php echo $element['recieved_folders_unity']['value']; ?></td>
            <td><?php echo $element['agreement']['value']; ?></td>
            <td><?php echo $element['agreement_date']['value']; ?></td>
            <td><?php echo $element['investigation_date']['value']; ?></td>
            <td><?php echo $element['validation_date']['value']; ?></td>
            <td style="<?php echo $current_status_style; ?>"><?php echo $element['recieved_folders_status']['value']; ?></td>
<?php
            if(!$dpe_permissions){
?>
            <td><?php echo $element['recieved_folders_user']['value']; ?></td>
<?php
            }
?>
            <td><?php echo $element['fiscalia']['value']; ?></td>
<?php
            if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('recieved_folders', <?php echo $element['recieved_folders_id']['value']; ?>)">Eliminar</button></td>
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
