<?php
    if(isset( $_POST['data']))
        $data = $_POST['data'];
    else
        $data = 'null';
?>

<?php
    if($data != 'null'){
?>

<table class="data-table table table-striped">
    <tr>
        <th>#</th>

<?php
        foreach(json_decode($data, true) as $element){
            foreach($element as $e){
?>
        <th><?php echo $e['name']; ?></th>
<?php
            }
            break;
        }
?>

    </tr>
<?php
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
<?php
            foreach($element as $sub){
?>
        <td><?php echo $sub['value']; ?></td>
<?php
            }
?>
    </tr>
<?php
            $i++;
        }
?>
</table>

<?php

    }
    else{
?>
    <h2>No hay registros</h2>
<?php

    }
?>