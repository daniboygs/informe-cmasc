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
        <th>Calificación</th>
        <th>Concurso</th>
        <th>Forma de Acción</th>
        <th>Comisión</th>
        <th>Violencia</th>
        <th>Modalidad</th>
        <th>Instrumento</th>
        <th>Justicia Alternativa</th>
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['nuc']['value']; ?></td>
        <td><?php echo $element['date']['value']; ?></td>
        <td><?php echo $element['crime_rate']['value']; ?></td>
        <td><?php echo $element['crime_contest']['value']; ?></td>
        <td><?php echo $element['crime_action']['value']; ?></td>
        <td><?php echo $element['crime_commission']['value']; ?></td>
        <td><?php echo $element['crime_violence']['value']; ?></td>
        <td><?php echo $element['crime_modality']['value']; ?></td>
        <td><?php echo $element['crime_instrument']['value']; ?></td>
        <td><?php echo $element['crime_alternative_justice']['value']; ?></td>
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