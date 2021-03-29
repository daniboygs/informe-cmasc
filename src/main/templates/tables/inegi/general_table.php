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
        <th>Número de Atendidos</th>
        <th>Unidad</th>
        <th>Estatus</th>
    </tr>
<?php
    if($data != 'null'){
        $i=1;
        foreach(json_decode($data, true) as $element){

            if(isset( $element['victim']['value'])){
                if($element['victim']['value'] != null && $element['imputed']['value'] != null && $element['crime']['value'] != null && $element['masc']['value'] != null){
                    $inegi_status = 'captured';
                    $inegi_status_label = 'Completo';
                }
                else{
                    $inegi_status = 'incompleted';
                    $inegi_status_label = 'Incompleto';
                }
            }
            else{
                $inegi_status = 'incompleted';
                $inegi_status_label = 'Incompleto';
            }
?> 
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $element['general_nuc']['value']; ?></td>
        <td><?php echo $element['general_date']['value']; ?></td>
        <td><?php echo $element['general_crime']['value']; ?></td>
        <td><?php echo $element['general_attended']['value']; ?></td>
        <td><?php echo $element['general_unity']['value']; ?></td>
        <td class="<?php echo $inegi_status; ?>"><?php echo $inegi_status_label; ?></td>
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
