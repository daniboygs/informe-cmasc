<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<table class="data-table">
    <tr>
        <th>#</th>
<?php
            foreach($data[0] as $field){
?> 
                <th><?php echo $field['name']; ?></th>
<?php
            
            }
?>
        <!--<th>#</th>
        <th>NUC</th>
        <th>Fecha</th>
        <th>Delito</th>
        <th>Unidad</th>
        <th>Acción</th>-->
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
<?php
            foreach($element as $field){
?> 
                <td><?php echo $field['value']; ?></td>
<?php
            
            }
?>
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
