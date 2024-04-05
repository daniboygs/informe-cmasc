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
            <th>Número de Atendidos</th>
            <th>Unidad</th>
            <th>Facilitador</th>
            <th>Fiscalía</th>
<?php
    if($crud_permissions){
?>
            <th>Acción</th>
<?php
    }
?>
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
            <td><?php echo $element['general_attended']['value']; ?></td>
            <td><?php echo $element['unity']['value']; ?></td>
            <td><?php echo $element['user']['value']; ?></td>
            <td><?php echo $element['fiscalia']['value']; ?></td>
<?php
            if($crud_permissions){
?>
            <td><button class="btn btn-outline-danger" onclick="deleteRecord('inegi', <?php echo $element['general_id']['value']; ?>)">Eliminar</button></td>
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
    </tbody>
</table>