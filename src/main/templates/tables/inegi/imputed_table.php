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
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Sexo</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Edad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Escolaridad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Ocupación</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Solicitante</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Requerido</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Tipo</th>
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
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_gener']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_age']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_scholarship']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_ocupation']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_applicant']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_required']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['imputed_type']['value']; ?></td>
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