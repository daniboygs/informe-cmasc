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
        <th>Nombre</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th>Calidad</th>
        <th>Acción</th>
    </tr>
<?php
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['name'].' '.$element['ap'].' '.$element['am']; ?></td>
        <td><?php echo $element['gener']; ?></td>
        <td><?php echo $element['age']; ?></td>
        <td><?php echo $element['type']; ?></td>
        <td><a class="btn btn-outline-danger" onclick="removeServedPeople(<?php echo $element['id']; ?>)">Eliminar</a></td>
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