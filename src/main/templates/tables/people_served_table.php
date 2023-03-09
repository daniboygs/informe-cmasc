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
        <th>Delito</th>
        <th>Personas atendidas</th>
        <th>Unidad</th>
        <th>Fiscalía</th>
        <!--<th>Acción</th>-->
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['people_served_nuc']['value']; ?></td>
        <td><?php echo $element['people_served_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['people_served_crime']['value']; ?></td>
        <td><?php echo $element['people_served_number']['value']; ?></td>
        <td><?php echo $element['people_served_unity']['value']; ?></td>
        <td><?php echo $element['people_served_fiscalia']['value']; ?></td>
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
