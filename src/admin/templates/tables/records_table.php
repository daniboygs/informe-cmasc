<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>

<table style="border: solid 1px #ccc; background-color: white;">
    <tr>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">#</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">NUC</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Delito</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Intervensión</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Cumplimiento</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Total o Parcial</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Mecanismo</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Mounto</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Unidad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Acción</th>
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $i; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_nuc']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_crime']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_intervention']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_compliance']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_total']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_mechanism']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_amount']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['agreement_unity']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><button class="btn btn-danger" onclick="deleteRecord('agreement', <?php echo $element['agreement_id']['value']; ?>)">Eliminar</button></td>
    </tr>
<?php
            $i++;
        }
    }
    else{
?> 
    <tr>
        <td colspan="7" style="text-align: center; padding: 7px;">
            No hay registros
        </td>
    </tr>
<?php

    }
?>
</table>
