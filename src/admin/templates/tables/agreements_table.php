<?php
    session_start();
    $crud_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 1 ? true : false) : false;
    $dpe_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 5 ? true : false) : false;
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		
    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="formHTMLTableToExcel({section: 'agreements'})">DESCARGAR &nbsp <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
</div>

<br>

<table class="data-table table table-striped overflow-table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha Inicio</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Intervinientes</th>
            <th>Cumplimiento</th>
            <th>Total o Parcial</th>
            <th>Mecanismo</th>
            <th>Monto en pesos</th>
            <th>Monto en especie</th>
            <th>Unidad</th>
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
    if($data != 'null'){

        $i=1;

        foreach(json_decode($data, true) as $element){
?> 
        <tr>
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['agreement_nuc']['value']; ?></td>
            <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
            <td><?php echo $element['agreement_date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['agreement_crime']['value']; ?></td>
            <td><?php echo $element['agreement_intervention']['value']; ?></td>
            <td><?php echo $element['agreement_compliance']['value']; ?></td>
            <td><?php echo $element['agreement_total']['value']; ?></td>
            <td><?php echo $element['agreement_mechanism']['value']; ?></td>
            <td><?php echo $element['agreement_amount']['value']; ?></td>
            <td><?php echo $element['agreement_amount_in_kind']['value']; ?></td>
            <td><?php echo $element['agreement_unity']['value']; ?></td>
<?php
            if(!$dpe_permissions){
?>
            <td><?php echo $element['agreement_user']['value']; ?></td>
<?php
            }
?>
            <td><?php echo $element['fiscalia']['value']; ?></td>
<?php
            if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('agreements', <?php echo $element['agreement_id']['value']; ?>)">Eliminar</button></td>
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