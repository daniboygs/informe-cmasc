<?php
    if(isset( $_POST['attr']))
        $attr = $_POST['attr'];
    else
        $attr = null;

    if(isset( $_POST['attr']['event_listener']))
        $event_listener = $_POST['attr']['event_listener'];
    else
        $event_listener = null;

    if($attr != null){
?>
        <button class="btn btn-<?php echo $attr['type'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $attr['title'];?>" 
<?php
    if($event_listener != null)
        echo $event_listener;
?>
        >
            <i class="fa fa-<?php echo $attr['icon']; ?>" aria-hidden="true"></i>
        </button>
<?php
    }
?>