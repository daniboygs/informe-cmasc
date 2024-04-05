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
            <th>Mecanismo</th>
            <th>Resultado</th>
            <th>Cumplimiento</th>
            <th>Total/Parcial</th>
            <th>Tipo de reparación</th>
            <th>Tipo de conclusión</th>
            <th>Monto recuperado</th>
            <th>Monto inmueble</th>
            <th>Turnado a</th>
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
            <td class="align-left bold-text"><?php echo $element['general_crime']['value']; ?></td>
            <td><?php echo $element['masc_mechanism']['value']; ?></td>
            <td><?php echo $element['masc_result']['value']; ?></td>
            <td><?php echo $element['masc_compliance']['value']; ?></td>
            <td><?php echo $element['masc_total']['value']; ?></td>
            <td><?php echo $element['masc_repair']['value']; ?></td>
            <td><?php echo $element['masc_conclusion']['value']; ?></td>
            <td><?php echo $element['masc_amount_recovered']['value']; ?></td>
            <td><?php echo $element['masc_amount_property']['value']; ?></td>
            <td><?php echo $element['masc_turned_to']['value']; ?></td>
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