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
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Mecanismo</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Resultado</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Cumplimiento</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Total</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Tipo de Reparación</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Tipo de Conclusión</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Monto Recuperado</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Monto Inmueble</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Turnado a</th>
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
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_mechanism']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_result']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_compliance']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_total']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_repair']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_conclusion']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_recovered_amount']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_amount_property']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['masc_turned_to']['value']; ?></td>
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