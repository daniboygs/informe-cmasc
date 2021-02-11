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
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha Ingreso</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Delito</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Unidad</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Carpeta Recibida</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fiscalía</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Municipio</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Observaciones</th>
        <th style="text-align: center; border: solid 1px #ccc; background-color: #152F4A; color: white; padding: 7px;">Fecha Libro</th>
    </tr>
<?php
    if($data != null){
        $i=1;
        foreach($data as $element){
?> 
    <tr>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $i; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_nuc']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_date']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_crime']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_unity']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_recieved_folder']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_fiscalia']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_municipality']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_observations']['value']; ?></td>
        <td style="text-align: center; border: solid 1px #ccc;"><?php echo $element['entered_folders_book_date']['value']; ?></td>
    </tr>
<?php
            $i++;
        }
    }
    else{
?> 
    <tr>
        <td colspan="7" style="text-align: center; padding: 7px;">
            No hay registros
        </td>
    </tr>
<?php

    }
?>
</table>
