<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<table class="data-table">
    <tr>
        <th>#</th>
        <th>NUC</th>
        <th>Fecha</th>
        <th>Delito</th>
        <th>Motivo de canalización</th>
        <th>Unidad</th>
        <!--<th>Acción</th>-->
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['folders_to_investigation_nuc']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_date']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_crime']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_channeling_reason']['value']; ?></td>
        <td><?php echo $element['folders_to_investigation_unity']['value']; ?></td>
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
