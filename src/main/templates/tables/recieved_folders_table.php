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
        <th>Unidad</th>
        <th>Fiscalía</th>
        <th>Estatus</th>
        <!--<th>Acción</th>-->
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){

            $current_status_style = 'background-color: #d4edda;';

            if($element['recieved_folders_status']['value'] == 'Tramite'){
                $current_status_style = 'background-color: #fff3cd;';
            }
            else{
                $current_status_style = 'background-color: #d4edda;';
            }
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['recieved_folders_nuc']['value']; ?></td>
        <td><?php echo $element['recieved_folders_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['recieved_folders_crime']['value']; ?></td>
        <td><?php echo $element['recieved_folders_unity']['value']; ?></td>
        <td><?php echo $element['recieved_folders_fiscalia']['value']; ?></td>
        <td style="<?php echo $current_status_style; ?>"><?php echo $element['recieved_folders_status']['value']; ?></td>
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
