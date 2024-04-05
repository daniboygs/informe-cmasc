<?php
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha ingreso</th>
            <th>Fecha captura INEGI</th>
            <th>Delito</th>
            <th>Calificación</th>
            <th>Concurso</th>
            <th>Forma de acción</th>
            <th>Comisión</th>
            <th>Violencia</th>
            <th>Modalidad</th>
            <th>Instrumento</th>
            <th>Justicia alternativa</th>
            <th>Unidad</th>
            <th>Facilitador</th>
            <th>Fiscalía</th>
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
            <td><?php echo $element['entered_date']['value']; ?></td>
            <td><?php echo $element['general_date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['crime_name']['value']; ?></td>
            <td><?php echo $element['crime_rate']['value']; ?></td>
            <td><?php echo $element['crime_contest']['value']; ?></td>
            <td><?php echo $element['crime_action']['value']; ?></td>
            <td><?php echo $element['crime_commission']['value']; ?></td>
            <td><?php echo $element['crime_violence']['value']; ?></td>
            <td><?php echo $element['crime_modality']['value']; ?></td>
            <td><?php echo $element['crime_instrument']['value']; ?></td>
            <td><?php echo $element['crime_alternative_justice']['value']; ?></td>
            <td><?php echo $element['unity']['value']; ?></td>
            <td><?php echo $element['user']['value']; ?></td>
            <td><?php echo $element['fiscalia']['value']; ?></td>
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