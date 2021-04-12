<?php
    session_start();
    
    $crud_permissions = false;

    if(isset($_SESSION['user_data']['type'])){
        if($_SESSION['user_data']['type'] == 1){
            $crud_permissions = true;
        }
    }

    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<table class="data-table table table-striped">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha</th>
        <th>Delito</th>
        <th>Intervinientes</th>
        <th>Cumplimiento</th>
        <th>Total o Parcial</th>
        <th>Mecanismo</th>
        <th>Monto en pesos</th>
        <th>Unidad</th>
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
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['agreement_nuc']['value']; ?></td>
        <td><?php echo $element['agreement_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['agreement_crime']['value']; ?></td>
        <td><?php echo $element['agreement_intervention']['value']; ?></td>
        <td><?php echo $element['agreement_compliance']['value']; ?></td>
        <td><?php echo $element['agreement_total']['value']; ?></td>
        <td><?php echo $element['agreement_mechanism']['value']; ?></td>
        <td><?php echo $element['agreement_amount']['value']; ?></td>
        <td><?php echo $element['agreement_unity']['value']; ?></td>
        <td><?php echo $element['agreement_user']['value']; ?></td>
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
</table>
