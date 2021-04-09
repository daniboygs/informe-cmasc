<?php
    $element_id = $_POST['element_id'];
    if(isset( $_POST['elements']))
        $elements = $_POST['elements'];
    else
        $elements = null;
        
    $element_event_listener = $_POST['element_event_listener'];
?>


<ul id="<?php echo $element_id; ?>" <?php echo $element_event_listener; ?>>    
<?php
    if($elements != null){
        foreach($elements as $element){
?> 
            <li><?php echo $element['name']; ?></li>
<?php
        }
    }
?>
</ul>
