<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<table class="data-table table table-striped" id="pending-agreements-table">
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
        <th>Etatus Acuerdo</th>
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        
        foreach(json_decode($data, true) as $element){
            $agreement_status = '';
            $agreement_class = '';
            $agreement_status_class = '';

            if($element['agreement_id']['value'] != ''){
                $agreement_status = 'Acuerdo';
                $agreement_class = '';
                $agreement_status_class = 'primary-status';
            }
            else{
                $agreement_status = 'Recibida';
                $agreement_class = '';
                $agreement_status_class = 'secondary-status';
            }
?> 
    <tr class="data-table-row" onclick="inegiStartCapture('<?php echo $element['recieved_id']['value']; ?>', '<?php echo $element['agreement_id']['value']; ?>')">
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['agreement_nuc']['value']; ?></td>
        <td><?php echo $element['date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['agreement_crime']['value']; ?></td>
        <td><?php echo $element['agreement_unity']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_intervention']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_compliance']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_total']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_mechanism']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_amount']['value']; ?></td>
        <td class="<?php echo $agreement_class; ?>"><?php echo $element['agreement_amount_in_kind']['value']; ?></td>
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
</table>
