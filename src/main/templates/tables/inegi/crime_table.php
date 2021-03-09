<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = null;
?>
<table style="background-color: white; width: 100%; overflow-x: auto;">
    <tr>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">#</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">NUC</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Calificación</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Concurso</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Forma de Acción</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Comisión</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Violencia</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Modalidad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Instrumento</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Justicia Alternativa</th>
        <!--<th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Acción</th>-->
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $i; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['nuc']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_rate']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_contest']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_action']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_commission']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_violence']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_modality']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_instrument']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['crime_alternative_justice']['value']; ?></td>
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