<?php
    session_start();
    $crud_permissions = isset($_SESSION['user_data']['type']) ? ($_SESSION['user_data']['type'] == 1 ? true : false) : false;
    $data = isset( $_POST['data']) ? $_POST['data'] : 'null';
    $nuc = isset($_POST['nuc']) ? $_POST['nuc'] : null;
    $initial_date = isset($_POST['initial_date']) ? $_POST['initial_date'] : null;
    $finish_date = isset($_POST['finish_date']) ? $_POST['finish_date'] : null;

    $initial_date = $initial_date != null ? str_replace('-', '/', date('d-m-Y', strtotime($initial_date))) : null;
    $finish_date = $finish_date != null ? str_replace('-', '/', date('d-m-Y', strtotime($finish_date))) : null;
    $composite_date = ($initial_date != null && $finish_date != null) 
    ? ($nuc != null ? '('.$initial_date.' - '.$finish_date.' - '.$nuc.')' : '('.$initial_date.' - '.$finish_date.')')
    : ($nuc != null ? '('.$nuc.')' : null);
?>

<div class="form-buttons" style="float: left !important; margin-bottom: 20px;">		
    <button type="button" class="btn btn-outline-success" style="height:38px;"  onclick="formHTMLTableToExcel({section: 'inegi_captured_records'})">DESCARGAR &nbsp <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
</div>

<div id="month-records-label-section" style="display: inline-flex;">REGISTROS CAPTURADOS &nbsp<a><?php echo $composite_date ?></a></div>

<table class="data-table table table-striped overflow-table">
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