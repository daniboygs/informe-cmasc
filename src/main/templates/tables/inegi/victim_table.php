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
        <th>Sexo</th>
        <th>Edad</th>
        <th>Escolaridad</th>
        <th>Ocupación</th>
        <th>Solicitante/Requerido</th>
        <th>Tipo</th>
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['nuc']['value']; ?></td>
        <td><?php echo $element['date']['value']; ?></td>
        <td><?php echo $element['victim_gener']['value']; ?></td>
        <td><?php echo $element['victim_age']['value']; ?></td>
        <td><?php echo $element['victim_scholarship']['value']; ?></td>
        <td><?php echo $element['victim_ocupation']['value']; ?></td>
        <td><?php echo $element['victim_applicant']['value']; ?></td>
        <td><?php echo $element['victim_type']['value']; ?></td>
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