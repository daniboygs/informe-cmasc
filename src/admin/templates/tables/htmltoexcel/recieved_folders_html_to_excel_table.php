<?php
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>

<table class="data-table table table-striped overflow-table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha Inicio</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Unidad</th>
            <th>Estatus</th>
            <th>Facilitador</th>
            <th>Fiscalía</th>
        </tr>
    </thead>
    <tbody>
<?php
    if($data != 'null'){
        
        $i=1;

        foreach(json_decode($data, true) as $element){

            $current_status_style = $element['recieved_folders_status']['value'] == 'Tramite' ? 'background-color: #fff3cd;' : 'background-color: #d4edda;';
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['recieved_folders_nuc']['value']; ?></td>
        <td class="bold-text"><?php echo $element['sigi_initial_date']['value']; ?></td>
        <td><?php echo $element['recieved_folders_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['recieved_folders_crime']['value']['listed_values']; ?></td>
        <td><?php echo $element['recieved_folders_unity']['value']; ?></td>
        <td style="<?php echo $current_status_style; ?>"><?php echo $element['recieved_folders_status']['value']; ?></td>
        <td><?php echo $element['recieved_folders_user']['value']; ?></td>
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
