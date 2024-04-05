<?php
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Unidad</th>
            <th>Intervinientes</th>
            <th>Cumplimiento</th>
            <th>Total o Parcial</th>
            <th>Mecanismo</th>
            <th>Monto en pesos</th>
            <th>Monto en especie</th>
            <th>Facilitador</th>
            <th>Etatus Acuerdo</th>
        </tr>
    </thead>
    <tbody>
<?php
    if($data != 'null'){

        $i=1;
        
        foreach(json_decode($data, true) as $element){

            $agreement_status = $element['agreement_id']['value'] != '' ? 'Acuerdo' : 'Recibida';
            $agreement_status_class = $element['agreement_id']['value'] != '' ? 'primary-status bold-text' : 'secondary-status bold-text';
?> 
        <tr class="data-table-row">
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['agreement_nuc']['value']; ?></td>
            <td><?php echo $element['date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['agreement_crime']['value']['listed_values']; ?></td>
            <td><?php echo $element['agreement_unity']['value']; ?></td>
            <td><?php echo $element['agreement_intervention']['value']; ?></td>
            <td><?php echo $element['agreement_compliance']['value']; ?></td>
            <td><?php echo $element['agreement_total']['value']; ?></td>
            <td><?php echo $element['agreement_mechanism']['value']; ?></td>
            <td><?php echo $element['agreement_amount']['value']; ?></td>
            <td><?php echo $element['agreement_amount_in_kind']['value']; ?></td>
            <td><?php echo $element['user_name']['value'].' '.$element['user_last_name']['value'].' '.$element['user_mothers_last_name']['value']; ?></td>
            <td class="<?php echo $agreement_status_class; ?>"><?php echo $agreement_status; ?></td>
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