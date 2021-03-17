<?php
    if(isset( $_POST['attr']))
        $attr = $_POST['attr'];
    else
        $attr = null;

    if($attr != null){
?>

        <div class="alert alert-<?php echo $attr['type'];?>" role="alert">
            <?php echo $attr['message']; ?>
        </div>

<?php
    }
?>