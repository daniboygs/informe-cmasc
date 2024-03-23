<?php
    session_start();
    $crud_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 1 ? true : false) : false;
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
    $initial_date = isset( $_POST['initial_date']) ? str_replace('-', '/', date('d-m-Y', strtotime($_POST['initial_date']))) : null;
    $finish_date = isset( $_POST['finish_date']) ? str_replace('-', '/', date('d-m-Y', strtotime($_POST['finish_date']))) : null;
    $composite_date = ($initial_date != null && $finish_date != null) ? '('.$initial_date.' - '.$finish_date.')' : '';
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		
    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="downloadInegi()">DESCARGAR &nbsp <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
</div>

<div id="month-records-label-section" style="display: inline-flex;">DATOS GENERALES &nbsp<p><?php echo $composite_date ?></p></div>

<table class="data-table table table-striped overflow-table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Número de Atendidos</th>
            <th>Unidad</th>
            <th>Datos Victimas</th>
            <th>Datos Imputados</th>
            <th>Caracteristicas del delito</th>
            <th>Datos generales del acuerdo</th>
            <th>Estatus de captura</th>
            <th>Tipo</th>
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
    </thead>
    <tbody>
<?php
    if($data != 'null'){

        $i=1;
        
        foreach(json_decode($data, true) as $element){

            
?> 
        <tr>
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['general_nuc']['value']; ?></td>
            <td><?php echo $element['general_date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['general_crime']['value']; ?></td>
            <td><?php echo $element['general_attended']['value']; ?></td>
            <td><?php echo $element['general_unity']['value']; ?></td>
            <td class="<?php echo $victim_status; ?>"><?php echo $victim_status_label; ?></td>
            <td class="<?php echo $imputed_status; ?>"><?php echo $imputed_status_label; ?></td>
            <td class="<?php echo $crime_status; ?>"><?php echo $crime_status_label; ?></td>
            <td class="<?php echo $masc_status; ?>"><?php echo $masc_status_label; ?></td>
            <td class="<?php echo $inegi_status; ?>"><?php echo $inegi_status_label; ?></td>
            <td class="<?php echo $agreement_status_class; ?>"><?php echo $agreement_status; ?></td>
            <td><?php echo $element['user']['value']; ?></td>
            <td><?php echo $element['fiscalia']['value']; ?></td>
<?php
            if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('inegi', <?php echo $element['general_id']['value']; ?>)">Eliminar</button></td>
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