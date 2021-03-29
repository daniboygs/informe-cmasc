<?php
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
        <th>Mecanismo</th>
        <th>Resultado</th>
        <th>Cumplimiento</th>
        <th>Total</th>
        <th>Tipo de Reparación</th>
        <th>Tipo de Conclusión</th>
        <th>Monto Recuperado</th>
        <th>Monto Inmueble</th>
        <th>Turnado a</th>
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
        <td><?php echo $element['masc_mechanism']['value']; ?></td>
        <td><?php echo $element['masc_result']['value']; ?></td>
        <td><?php echo $element['masc_compliance']['value']; ?></td>
        <td><?php echo $element['masc_total']['value']; ?></td>
        <td><?php echo $element['masc_repair']['value']; ?></td>
        <td><?php echo $element['masc_conclusion']['value']; ?></td>
        <td><?php echo $element['masc_recovered_amount']['value']; ?></td>
        <td><?php echo $element['masc_amount_property']['value']; ?></td>
        <td><?php echo $element['masc_turned_to']['value']; ?></td>
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