<?php
    session_start();
    
    if(isset( $_POST['nuc']))
        $nuc = $_POST['nuc']['value'];
    else
        $nuc = 'null';

    if($_POST['rejected_folder_id']['value'] != null){
        $header = 'Editando '.$nuc;
    }
    else{
        $header = 'Nuevo '.$nuc;
    }

    if($_POST['folio']['value'] != null){
        $folio = 'value="'.$_POST['folio']['value'].'"';
    }
    else{
        $folio = '';
    }

    if(isset( $_POST['entered_folder_id']))
        $entered_folder_id = $_POST['entered_folder_id']['value'];
    else
        $entered_folder_id = 'null';

?>

<div class="modal fade bd-example-modal-lg" id="large-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel"><?php echo $header; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">

                <form>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Folio:</label>
                        <input type="text" class="form-control" id="rejected_folio" <?php echo $folio; ?> maxlength="13">
                    </div>

                    <!--<div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>-->

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
<?php
                if($_POST['rejected_folder_id']['value'] != null){
?>
                    <button type="button" class="btn btn-outline-success" onclick="updateRejectedFolder(<?php echo $_POST['rejected_folder_id']['value']; ?>)">Guardar</button>
<?php
                }
                else{
?>
                    <button type="button" class="btn btn-outline-success" onclick="saveRejectedFolder(<?php echo $entered_folder_id; ?>)">Guardar</button>
<?php
                }

?>
                
                
            </div>
        
        </div>
    </div>

</div>
