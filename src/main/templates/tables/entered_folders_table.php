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
        <th>Fecha Ingreso</th>
        <th>Delito</th>
        <th>Unidad</th>
        <th>Carpeta Recibida</th>
        <th>Motivo de rechazo</th>
        <th>MP Canalizador</th>
        <th>Fiscalía</th>
        <th>Municipio</th>
        <th>Observaciones</th>
        <!--<th>Fecha Libro</th>-->
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td class="bold-text"><?php echo $element['entered_folders_nuc']['value']; ?></td>
        <td><?php echo $element['entered_folders_date']['value']; ?></td>
        <td class="align-left bold-text"><?php echo $element['entered_folders_crime']['value']; ?></td>
        <td><?php echo $element['entered_folders_unity']['value']; ?></td>
        <td><?php echo $element['entered_folders_recieved_folder']['value']; ?></td>
        <td><?php echo $element['entered_folders_rejection_reason']['value']; ?></td>
        <td><?php echo $element['entered_folders_mp_channeler']['value']; ?></td>
        <td><?php echo $element['entered_folders_fiscalia']['value']; ?></td>
        <td><?php echo $element['entered_folders_municipality']['value']; ?></td>
        <td><?php echo $element['entered_folders_observations']['value']; ?></td>
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
