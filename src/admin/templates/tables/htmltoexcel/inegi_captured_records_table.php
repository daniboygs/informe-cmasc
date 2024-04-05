<?php
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>NUC</th>
            <th>Fecha</th>
            <th>Delito</th>
            <th>Número de Atendidos</th>
            <th>Unidad</th>
            <th>Datos Victimas</th>
            <th>Datos Imputados</th>
            <th>Caracteristicas del delito</th>
            <th>Datos generales del acuerdo</th>
            <th>Estatus de captura</th>
            <th>Tipo</th>
            <th>Facilitador</th>
            <th>Fiscalía</th>
        </tr>
    </thead>
    <tbody>
<?php
    if($data != 'null'){

        $i=1;
        
        foreach(json_decode($data, true) as $element){

            if(isset( $element['victim']['value'])){
                if($element['victim']['value'] != null && $element['imputed']['value'] != null
                && $element['crime']['value'] == $element['crime_inegi']['value']){
                    if($element['general_agreement_id']['value'] != null){
                        if($element['masc']['value'] != null){
                            $inegi_status = 'captured';
                            $inegi_status_label = 'Completo';
                        }
                        else{
                            $inegi_status = 'incompleted';
                            $inegi_status_label = 'No capturado';
                        }
                    }
                    else{
                        $inegi_status = 'captured';
                        $inegi_status_label = 'Completo';
                    }
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

            if($element['victim']['value'] != null){
                $victim_status = 'captured';
                $victim_status_label = 'Capturado';
            }
            else{
                $victim_status = 'incompleted';
                $victim_status_label = 'No capturado';
            }

            if($element['imputed']['value'] != null){
                $imputed_status = 'captured';
                $imputed_status_label = 'Capturado';
            }
            else{
                $imputed_status = 'incompleted';
                $imputed_status_label = 'No capturado';
            }

            /*if($element['masc']['value'] != null){
                $masc_status = 'captured';
                $masc_status_label = 'Capturado';
            }
            else{
                $masc_status = 'incompleted';
                $masc_status_label = 'No capturado';
            }*/

            if($element['crime']['value'] == $element['crime_inegi']['value']){
                $crime_status = 'captured';
                $crime_status_label = 'Capturado';
            }
            else{
                $crime_status = 'incompleted';
                $crime_status_label = 'No todos los delitos fueron capturados';
            }

            if($element['general_agreement_id']['value'] != null){
                $agreement_status = 'Acuerdo';
                $agreement_class = '';
                $agreement_status_class = 'primary-status';

                if($element['masc']['value'] != null){
                    $masc_status = 'captured';
                    $masc_status_label = 'Capturado';
                }
                else{
                    $masc_status = 'incompleted';
                    $masc_status_label = 'No capturado';
                }
            }
            else{
                $agreement_status = 'Recibida';
                $agreement_class = '';
                $agreement_status_class = 'secondary-status';

                $masc_status = 'secondary-status';
                $masc_status_label = 'N/A';
            }

            
?> 
        <tr>
            <td><?php echo $i; ?></td>
            <td class="bold-text"><?php echo $element['general_nuc']['value']; ?></td>
            <td><?php echo $element['general_date']['value']; ?></td>
            <td class="align-left bold-text"><?php echo $element['general_crime']['value']; ?></td>
            <td><?php echo $element['general_attended']['value']; ?></td>
            <td><?php echo $element['general_unity']['value']; ?></td>
            <td class="<?php echo $victim_status; ?>"><?php echo $victim_status_label; ?></td>
            <td class="<?php echo $imputed_status; ?>"><?php echo $imputed_status_label; ?></td>
            <td class="<?php echo $crime_status; ?>"><?php echo $crime_status_label; ?></td>
            <td class="<?php echo $masc_status; ?>"><?php echo $masc_status_label; ?></td>
            <td class="<?php echo $inegi_status; ?>"><?php echo $inegi_status_label; ?></td>
            <td class="<?php echo $agreement_status_class; ?>"><?php echo $agreement_status; ?></td>
            <td><?php echo $element['user']['value']; ?></td>
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